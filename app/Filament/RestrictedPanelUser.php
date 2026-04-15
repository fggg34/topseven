<?php

namespace App\Filament;

use Illuminate\Support\Facades\Auth;

final class RestrictedPanelUser
{
    /**
     * Admin users matched here get a reduced panel (no Site Settings, Highlights, Hotels, FAQ/About/Contact CMS).
     *
     * @var list<string>
     */
    private const LIMITED_ACCESS_EMAILS = [
        'topseven@impactstudio.al',
    ];

    public static function isCurrentUser(): bool
    {
        $email = Auth::user()?->email;
        if ($email === null || $email === '') {
            return false;
        }

        return in_array(mb_strtolower($email), self::limitedEmailsLowercased(), true);
    }

    /**
     * @return list<string>
     */
    private static function limitedEmailsLowercased(): array
    {
        return array_map(static fn (string $e): string => mb_strtolower($e), self::LIMITED_ACCESS_EMAILS);
    }
}
