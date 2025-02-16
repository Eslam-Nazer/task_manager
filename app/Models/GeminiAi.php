<?php

namespace App\Models;

use Gemini;
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
     * @param string $promt
     * @return Gemini\Responses\GenerativeModel\GenerateContentResponse|array
     */
    public function scopeGemini(string $promt, bool $parts = false): GenerateContentResponse|array
    {
        $key = getenv('GEMINI_API_KEY');
        $client = Gemini::client($key);

        if ($parts) {
            return $client->geminiPro()->generateContent($promt)->parts();
        }

        return $client->geminiPro()->generateContent($promt);
    }
}
