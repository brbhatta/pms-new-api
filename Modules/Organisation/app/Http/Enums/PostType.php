<?php

namespace Modules\Organisation\Http\Enums;

enum PostType: string
{
    case SECTION_OFFICER = 'section_officer';
    case DEPUTY_SECRETARY = 'deputy_secretary';
    case JOINT_SECRETARY = 'joint_secretary';
    case ADDITIONAL_SECRETARY = 'additional_secretary';
    case SECRETARY = 'secretary';

    public function label(): string
    {
        return match($this) {
            self::SECTION_OFFICER => 'Section Officer',
            self::DEPUTY_SECRETARY => 'Deputy Secretary',
            self::JOINT_SECRETARY => 'Joint Secretary',
            self::ADDITIONAL_SECRETARY => 'Additional Secretary',
            self::SECRETARY => 'Secretary',
        };
    }

    /**
     * Higher number means higher in the hierarchy (more authority).
     */
    public function level(): int
    {
        return match($this) {
            self::SECTION_OFFICER => 1,
            self::DEPUTY_SECRETARY => 2,
            self::JOINT_SECRETARY => 3,
            self::ADDITIONAL_SECRETARY => 4,
            self::SECRETARY => 5,
        };
    }

    public static function orderedHierarchy(): array
    {
        return [
            self::SECTION_OFFICER,
            self::DEPUTY_SECRETARY,
            self::JOINT_SECRETARY,
            self::ADDITIONAL_SECRETARY,
            self::SECRETARY,
        ];
    }
}
