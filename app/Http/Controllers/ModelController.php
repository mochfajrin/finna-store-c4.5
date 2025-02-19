<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ModelController extends Controller
{
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

        // Prepare training data
        $trainingData = [];
        foreach ($evaluationsDataTraining as $eval) {
            $trainingData[] = [
                'riwayat' => $eval->riwayat ?? 0,
                'ktp' => $eval->ktp ?? 0,
                'skck' => $eval->skck ?? 0,
                'ijazah' => $eval->ijazah ?? 0,
                'buta_warna' => $eval->buta_warna ?? 0,
                'kemampuan' => $eval->kemampuan ?? 0,
                'wawancara' => $eval->wawancara ?? 0,
                'status' => $eval->status,
            ];
        }

        // Build the decision tree
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

    private function calculateInformationGain($data, $attribute, $entropy)
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
            if ($subsetCount == 0) {
                continue;
            }
            $subsetEntropy = $this->calculateEntropy($subset);
            $weightedEntropy += ($subsetCount / $total) * $subsetEntropy;
            $probability = $subsetCount / $total;
            if ($probability > 0) {
                $splitInfo -= $probability * log($probability, 2);
            }
        }

        $informationGain = $entropy - $weightedEntropy;
        $gainRatio = $splitInfo != 0 ? $informationGain / $splitInfo : 0;

        return [
            'information_gain' => $informationGain,
            'gain_ratio' => $gainRatio,
        ];
    }

    private function selectBestAttribute($data, $attributes)
    {
        $entropy = $this->calculateEntropy($data);
        $bestAttribute = null;
        $maxGainRatio = -INF;

        foreach ($attributes as $attribute) {
            $result = $this->calculateInformationGain($data, $attribute, $entropy);
            $gainRatio = $result['gain_ratio'];
            if ($gainRatio > $maxGainRatio) {
                $maxGainRatio = $gainRatio;
                $bestAttribute = $attribute;
            }
        }

        return $bestAttribute;
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

        $bestAttribute = $this->selectBestAttribute($data, $attributes);
        if ($bestAttribute === null) {
            $counts = array_count_values($labels);
            arsort($counts);
            return ['leaf' => array_key_first($counts)];
        }

        $remainingAttributes = array_diff($attributes, [$bestAttribute]);
        $tree = [
            'attribute' => $bestAttribute,
            'branches' => [],
        ];

        $values = array_unique(array_column($data, $bestAttribute));
        foreach ($values as $value) {
            $subset = array_filter($data, function ($row) use ($bestAttribute, $value) {
                return $row[$bestAttribute] == $value;
            });
            if (empty($subset)) {
                $counts = array_count_values($labels);
                arsort($counts);
                $tree['branches'][$value] = ['leaf' => array_key_first($counts)];
            } else {
                $tree['branches'][$value] = $this->buildTree($subset, $remainingAttributes);
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
        if (!isset($tree['branches'][$value])) {
            // Handle unseen value; could return majority class or 0
            return 0;
        }
        return $this->classify($tree['branches'][$value], $instance);
    }
}
