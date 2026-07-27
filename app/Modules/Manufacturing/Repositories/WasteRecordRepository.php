<?php

namespace Modules\Manufacturing\Repositories;

use App\Repositories\BaseRepository;
use Modules\Manufacturing\Models\WasteRecord;

class WasteRecordRepository extends BaseRepository
{
    protected function modelClass(): string
    {
        return WasteRecord::class;
    }

    public function findByMo(int $moId)
    {
        return $this->model->where('manufacturing_order_id', $moId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findByWasteType(string $wasteType)
    {
        return $this->model->where('waste_type', $wasteType)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findHighWaste(\Carbon\Carbon $since = null)
    {
        $query = $this->model->selectRaw('waste_type, SUM(quantity) as total_waste')
            ->groupBy('waste_type')
            ->orderBy('total_waste', 'desc');

        if ($since) {
            $query->where('created_at', '>=', $since);
        }

        return $query->get();
    }
}
