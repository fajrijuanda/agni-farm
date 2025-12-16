<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageView extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'product_id',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the product for this page view (if product page)
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Record a page view
     */
    public static function record(string $page, ?int $productId = null): self
    {
        return self::create([
            'page' => $page,
            'product_id' => $productId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Get views for a specific page
     */
    public static function getViewCount(string $page): int
    {
        return self::where('page', $page)->count();
    }

    /**
     * Get views for today
     */
    public static function getTodayViews(): int
    {
        return self::whereDate('created_at', today())->count();
    }

    /**
     * Get views for this week
     */
    public static function getWeekViews(): int
    {
        return self::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ])->count();
    }

    /**
     * Get views for this month
     */
    public static function getMonthViews(): int
    {
        return self::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }
}
