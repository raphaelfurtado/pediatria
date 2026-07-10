<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class ActivityObserver
{
    /**
     * Attribute changes that are not worth logging on their own
     * (e.g. the remember_token rewritten on every "remember me" login).
     */
    protected array $ignored = ['remember_token', 'updated_at', 'created_at'];

    protected array $verbs = [
        'created' => 'criou',
        'updated' => 'editou',
        'deleted' => 'excluiu',
        'restored' => 'restaurou',
    ];

    public function created(Model $model): void
    {
        $this->log('created', $model);
    }

    public function updated(Model $model): void
    {
        $meaningful = array_diff(array_keys($model->getChanges()), $this->ignored);

        if (empty($meaningful)) {
            return; // nothing user-relevant changed
        }

        $this->log('updated', $model, ['changed' => array_values($meaningful)]);
    }

    public function deleted(Model $model): void
    {
        $this->log('deleted', $model);
    }

    public function restored(Model $model): void
    {
        $this->log('restored', $model);
    }

    protected function log(string $event, Model $model, ?array $properties = null): void
    {
        $user = auth()->user();
        $actor = $user?->name ?? 'Sistema';
        $verb = $this->verbs[$event] ?? $event;
        $label = ActivityLog::labelFor($model);
        $title = $model->title ?? $model->name ?? ('#'.$model->getKey());

        ActivityLog::create([
            'user_id' => $user?->id,
            'user_name' => $actor,
            'event' => $event,
            'subject_type' => $model::class,
            'subject_id' => $model->getKey(),
            'description' => trim("{$actor} {$verb} {$label} \"{$title}\""),
            'properties' => $properties,
            'ip_address' => request()->ip(),
        ]);
    }
}
