<?php

namespace App\Traits;

trait Timestamp
{
    /**
     * Get formatted created date
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at ? date('Y-m-d H:i:s', strtotime($this->created_at)) : null;
    }

    /**
     * Get formatted updated date
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updated_at ? date('Y-m-d H:i:s', strtotime($this->updated_at)) : null;
    }

    /**
     * Set created_at timestamp before insert
     */
    protected function beforeInsert(): void
    {
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }

    /**
     * Set updated_at timestamp before update
     */
    protected function beforeUpdate(): void
    {
        $this->updated_at = date('Y-m-d H:i:s');
    }
}
