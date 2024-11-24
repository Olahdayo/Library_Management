<?php

namespace App\Interfaces;

interface Borrowable
{
    /**
     * Check if the item is available for borrowing
     * @return bool
     */
    public function isAvailable(): bool;

    /**
     * Borrow the item
     * @param int $userId ID of the user borrowing the item
     * @return bool
     */
    public function borrow(int $userId): bool;

    /**
     * Return the borrowed item
     * @param int $userId ID of the user returning the item
     * @return bool
     */
    public function return(int $userId): bool;

    /**
     * Get the due date for the borrowed item
     * @return string|null Returns the due date or null if not borrowed
     */
    public function getDueDate(): ?string;

    /**
     * Get the current status of the item
     * @return string Returns status (e.g., 'available', 'borrowed', 'overdue')
     */
    public function getStatus(): string;
}
