<?php

namespace App\Models;

use Gemini;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;

class GeminiAi extends Model
{
    /**
     * @use SoftDeletes<\Illuminate\Database\Eloquent\SoftDeletes>
     */
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        if (!app()->runningInConsole()) {
            static::creating(function ($gemini) {
                $gemini->user_id = Auth::id();
            });

            static::updating(function ($gemini) {
                $gemini->user_id = Auth::id();
            });
        }
    }

    /**
     * Summary of table
     * @var string
     */
    protected $table = "gemini_ais";

    /**
     * Summary of guarded
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * Summary of casts
     * @return array{context: string}
     */
    protected function casts(): array
    {
        return [
            'context' => 'array',
        ];
    }

    /**
     * Summary of users
     * @return BelongsTo<User, GeminiAi>
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Summary of scopeGemini
     * @param string $prompt
     * @return Gemini\Responses\GenerativeModel\GenerateContentResponse|array|string
     */
    public static function Gemini(string $prompt, bool $parts = false, $onlyText = false): GenerateContentResponse|array|string
    {
        $key = getenv('GEMINI_API_KEY');
        $client = Gemini::client($key);

        if ($parts) {
            if ($onlyText) {
                return $client->geminiPro()->generateContent($prompt)->parts()[0]->text;
            }
            return $client->geminiPro()->generateContent($prompt)->parts();
        }

        return $client->geminiPro()->generateContent($prompt);
    }
}
