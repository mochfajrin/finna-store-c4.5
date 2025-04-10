<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ModelController extends Controller
{
    private $continuousAttributes = ['kemampuan', 'wawancara'];

    public function __invoke()
    {
        $evaluations = DB::table('pelamars as p')
            ->leftJoin('tes as t', 'p.id', '=', 't.pelamar_id')
            ->leftJoin('evaluasis as e', 'p.id', '=', 'e.pelamar_id')
            ->leftJoin('kriterias as k', 'e.kriteria_id', '=', 'k.id')
            ->leftJoin('wawancaras as w', 'p.id', '=', 'w.pelamar_id')
            ->leftJoin('penilaians as n', 'p.id', '=', 'n.pelamar_id')
            ->select([
                'p.id as pelamar_id',
                'p.nama as nama',
                DB::raw("MAX(CASE WHEN k.judul = 'riwayat' THEN e.nilai END) as riwayat"),
                DB::raw("MAX(CASE WHEN k.judul = 'ktp' THEN e.nilai END) as ktp"),
                DB::raw("MAX(CASE WHEN k.judul = 'skck' THEN e.nilai END) as skck"),
                DB::raw("MAX(CASE WHEN k.judul = 'ijazah' THEN e.nilai END) as ijazah"),
                DB::raw("MAX(CASE WHEN t.jenis = 'buta_warna' THEN t.nilai END) as buta_warna"),
                DB::raw("MAX(CASE WHEN t.jenis = 'kemampuan' THEN t.nilai END) as kemampuan"),
                'w.nilai as wawancara',
                'n.status as status',
                DB::raw("
            COALESCE(MAX(CASE WHEN k.judul = 'riwayat' THEN e.nilai END), 0) +
            COALESCE(MAX(CASE WHEN k.judul = 'ktp' THEN e.nilai END), 0) +
            COALESCE(MAX(CASE WHEN k.judul = 'skck' THEN e.nilai END), 0) +
            COALESCE(MAX(CASE WHEN k.judul = 'ijazah' THEN e.nilai END), 0) +
            COALESCE(MAX(CASE WHEN t.jenis = 'buta_warna' THEN t.nilai END), 0) +
            COALESCE(MAX(CASE WHEN t.jenis = 'kemampuan' THEN t.nilai END), 0) +
            COALESCE(w.nilai, 0) +
            COALESCE(n.status, 0)
        AS total")
            ])
            ->groupBy('p.id', 'p.nama', 'w.nilai', 'n.status')
            ->get();


        return view('model.model', [
            'evaluations' => $evaluations
        ]);
    }

    public function calculateC45(Penilaian $penilaian)
    {
        if (!$penilaian) {
            Log::info('Penilaian not found');
            return response()->json([
                'message' => 'Penilaian not found'
            ], 404);
        }

        // Fetch training data excluding the current pelamar
        $evaluationsDataTraining = DB::table('pelamars as p')
            ->leftJoin('tes as t', 'p.id', '=', 't.pelamar_id')
            ->leftJoin('evaluasis as e', 'p.id', '=', 'e.pelamar_id')
            ->leftJoin('kriterias as k', 'e.kriteria_id', '=', 'k.id')
            ->leftJoin('wawancaras as w', 'p.id', '=', 'w.pelamar_id')
            ->leftJoin('penilaians as n', 'p.id', '=', 'n.pelamar_id')
            ->select([
                'p.id as pelamar_id',
                'p.nama as nama',
                DB::raw("MAX(CASE WHEN k.judul = 'riwayat' THEN e.nilai END) as riwayat"),
                DB::raw("MAX(CASE WHEN k.judul = 'ktp' THEN e.nilai END) as ktp"),
                DB::raw("MAX(CASE WHEN k.judul = 'skck' THEN e.nilai END) as skck"),
                DB::raw("MAX(CASE WHEN k.judul = 'ijazah' THEN e.nilai END) as ijazah"),
                DB::raw("MAX(CASE WHEN t.jenis = 'buta_warna' THEN t.nilai END) as buta_warna"),
                DB::raw("MAX(CASE WHEN t.jenis = 'kemampuan' THEN t.nilai END) as kemampuan"),
                'w.nilai as wawancara',
                'n.status as status',
            ])
            ->where('p.id', '!=', $penilaian->pelamar_id)
            ->groupBy('p.id', 'p.nama', 'w.nilai', 'n.status')
            ->get();

        // Prepare training data with correct data types
        $trainingData = [];
        foreach ($evaluationsDataTraining as $eval) {
            $trainingData[] = [
                'riwayat' => (int)($eval->riwayat ?? 0),
                'ktp' => (int)($eval->ktp ?? 0),
                'skck' => (int)($eval->skck ?? 0),
                'ijazah' => (int)($eval->ijazah ?? 0),
                'buta_warna' => (int)($eval->buta_warna ?? 0),
                'kemampuan' => (int)($eval->kemampuan ?? 0),
                'wawancara' => (int)($eval->wawancara ?? 0),
                'status' => $eval->status,
            ];
        }

        // Build decision tree with continuous handling
        $attributes = ['riwayat', 'ktp', 'skck', 'ijazah', 'buta_warna', 'kemampuan', 'wawancara'];
        $tree = $this->buildTree($trainingData, $attributes);

        // Fetch current pelamar's data
        $currentPelamar = DB::table('pelamars as p')
            ->leftJoin('tes as t', 'p.id', '=', 't.pelamar_id')
            ->leftJoin('evaluasis as e', 'p.id', '=', 'e.pelamar_id')
            ->leftJoin('kriterias as k', 'e.kriteria_id', '=', 'k.id')
            ->leftJoin('wawancaras as w', 'p.id', '=', 'w.pelamar_id')
            ->select([
                'p.id as pelamar_id',
                DB::raw("MAX(CASE WHEN k.judul = 'riwayat' THEN e.nilai END) as riwayat"),
                DB::raw("MAX(CASE WHEN k.judul = 'ktp' THEN e.nilai END) as ktp"),
                DB::raw("MAX(CASE WHEN k.judul = 'skck' THEN e.nilai END) as skck"),
                DB::raw("MAX(CASE WHEN k.judul = 'ijazah' THEN e.nilai END) as ijazah"),
                DB::raw("MAX(CASE WHEN t.jenis = 'buta_warna' THEN t.nilai END) as buta_warna"),
                DB::raw("MAX(CASE WHEN t.jenis = 'kemampuan' THEN t.nilai END) as kemampuan"),
                'w.nilai as wawancara',
            ])
            ->where('p.id', '=', $penilaian->pelamar_id)
            ->groupBy('p.id', 'w.nilai')
            ->first();

        if (!$currentPelamar) {
            Log::info('Current pelamar data not found');
            return response()->json(['message' => 'Current pelamar data not found'], 404);
        }

        // Prepare instance for prediction
        $instance = [
            'riwayat' => $currentPelamar->riwayat ?? 0,
            'ktp' => $currentPelamar->ktp ?? 0,
            'skck' => $currentPelamar->skck ?? 0,
            'ijazah' => $currentPelamar->ijazah ?? 0,
            'buta_warna' => $currentPelamar->buta_warna ?? 0,
            'kemampuan' => $currentPelamar->kemampuan ?? 0,
            'wawancara' => $currentPelamar->wawancara ?? 0,
        ];

        // Predict status
        $predictedStatus = $this->classify($tree, $instance);

        // Update and save the penilaian status
        $penilaian->status = $predictedStatus;
        $penilaian->save();

        return response()->json([
            'message' => 'Status calculated successfully',
            'instance' => $instance,
            'status' => $predictedStatus
        ], 200);
    }

    // Helper functions for C4.5 algorithm

    private function calculateEntropy($data)
    {
        $counts = [];
        $total = count($data);
        if ($total == 0) {
            return 0;
        }
        foreach ($data as $row) {
            $label = $row['status'];
            if (!isset($counts[$label])) {
                $counts[$label] = 0;
            }
            $counts[$label]++;
        }
        $entropy = 0;
        foreach ($counts as $count) {
            $probability = $count / $total;
            if ($probability > 0) {
                $entropy -= $probability * log($probability, 2);
            }
        }
        return $entropy;
    }

    private function calculateInformationGainForCategorical($data, $attribute, $entropy)
    {
        $values = array_unique(array_column($data, $attribute));
        $total = count($data);
        $weightedEntropy = 0;
        $splitInfo = 0;

        foreach ($values as $value) {
            $subset = array_filter($data, function ($row) use ($attribute, $value) {
                return $row[$attribute] == $value;
            });
            $subsetCount = count($subset);
            if ($subsetCount == 0) continue;

            $subsetEntropy = $this->calculateEntropy($subset);
            $weightedEntropy += ($subsetCount / $total) * $subsetEntropy;

            $probability = $subsetCount / $total;
            if ($probability > 0) {
                $splitInfo -= $probability * log($probability, 2);
            }
        }

        $informationGain = $entropy - $weightedEntropy;
        $gainRatio = $splitInfo != 0 ? $informationGain / $splitInfo : 0;

        return ['gain_ratio' => $gainRatio];
    }

    private function calculateInformationGainForContinuous(&$data, $attribute, $entropy)
    {
        usort($data, function ($a, $b) use ($attribute) {
            return $a[$attribute] <=> $b[$attribute];
        });

        $total = count($data);
        $maxGainRatio = -INF;
        $bestThreshold = null;

        for ($i = 0; $i < $total - 1; $i++) {
            if ($data[$i]['status'] == $data[$i + 1]['status']) continue;

            $threshold = ($data[$i][$attribute] + $data[$i + 1][$attribute]) / 2;
            $left = array_slice($data, 0, $i + 1);
            $right = array_slice($data, $i + 1);

            $leftEntropy = $this->calculateEntropy($left);
            $rightEntropy = $this->calculateEntropy($right);

            $weightedEntropy = (count($left) / $total) * $leftEntropy + (count($right) / $total) * $rightEntropy;
            $informationGain = $entropy - $weightedEntropy;

            $splitInfo = 0;
            $probLeft = count($left) / $total;
            $probRight = count($right) / $total;

            if ($probLeft > 0) $splitInfo -= $probLeft * log($probLeft, 2);
            if ($probRight > 0) $splitInfo -= $probRight * log($probRight, 2);

            $gainRatio = $splitInfo != 0 ? $informationGain / $splitInfo : 0;

            if ($gainRatio > $maxGainRatio) {
                $maxGainRatio = $gainRatio;
                $bestThreshold = $threshold;
            }
        }

        return [
            'gain_ratio' => $maxGainRatio ?: 0,
            'threshold' => $bestThreshold
        ];
    }

    private function selectBestAttribute($data, $attributes)
    {
        $entropy = $this->calculateEntropy($data);
        $bestAttribute = null;
        $maxGainRatio = -INF;
        $bestThreshold = null;

        foreach ($attributes as $attribute) {
            if (in_array($attribute, $this->continuousAttributes)) {
                $result = $this->calculateInformationGainForContinuous($data, $attribute, $entropy);
                $gainRatio = $result['gain_ratio'];
                $threshold = $result['threshold'];
            } else {
                $result = $this->calculateInformationGainForCategorical($data, $attribute, $entropy);
                $gainRatio = $result['gain_ratio'];
                $threshold = null;
            }

            if ($gainRatio > $maxGainRatio) {
                $maxGainRatio = $gainRatio;
                $bestAttribute = $attribute;
                $bestThreshold = $threshold;
            }
        }

        return [
            'attribute' => $bestAttribute,
            'threshold' => $bestThreshold
        ];
    }

    private function buildTree($data, $attributes)
    {
        $labels = array_column($data, 'status');
        if (count(array_unique($labels)) === 1) {
            return ['leaf' => $labels[0]];
        }

        if (empty($attributes)) {
            $counts = array_count_values($labels);
            arsort($counts);
            return ['leaf' => array_key_first($counts)];
        }

        $best = $this->selectBestAttribute($data, $attributes);
        $bestAttribute = $best['attribute'];
        $bestThreshold = $best['threshold'];

        if (!$bestAttribute) {
            $counts = array_count_values($labels);
            arsort($counts);
            return ['leaf' => array_key_first($counts)];
        }

        $remainingAttributes = array_diff($attributes, [$bestAttribute]);

        if (in_array($bestAttribute, $this->continuousAttributes)) {
            $leftSubset = array_filter($data, function ($row) use ($bestAttribute, $bestThreshold) {
                return $row[$bestAttribute] <= $bestThreshold;
            });
            $rightSubset = array_filter($data, function ($row) use ($bestAttribute, $bestThreshold) {
                return $row[$bestAttribute] > $bestThreshold;
            });

            $tree = [
                'attribute' => $bestAttribute,
                'threshold' => $bestThreshold,
                'branches' => [
                    'left' => $this->buildTree($leftSubset, $remainingAttributes),
                    'right' => $this->buildTree($rightSubset, $remainingAttributes),
                ]
            ];
        } else {
            $values = array_unique(array_column($data, $bestAttribute));
            $tree = ['attribute' => $bestAttribute, 'branches' => []];
            foreach ($values as $value) {
                $subset = array_filter($data, function ($row) use ($bestAttribute, $value) {
                    return $row[$bestAttribute] == $value;
                });
                $tree['branches'][$value] = empty($subset)
                    ? ['leaf' => array_key_first(array_count_values($labels))]
                    : $this->buildTree($subset, $remainingAttributes);
            }
        }

        return $tree;
    }

    private function classify($tree, $instance)
    {
        if (isset($tree['leaf'])) {
            return $tree['leaf'];
        }

        $attribute = $tree['attribute'];
        $value = $instance[$attribute] ?? null;

        if (isset($tree['threshold'])) {
            $branch = ($value <= $tree['threshold']) ? 'left' : 'right';
            return $this->classify($tree['branches'][$branch], $instance);
        } else {
            if (!isset($tree['branches'][$value])) {
                return 0; // Default class for unseen categories
            }
            return $this->classify($tree['branches'][$value], $instance);
        }
    }
}
