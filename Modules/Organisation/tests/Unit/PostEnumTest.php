<?php

use Modules\Organisation\Http\Enums\PostType;

uses(Modules\Organisation\Tests\TestCase::class);

it('returns expected label, level and value for each post', function () {
    $expected = [
        'section_officer' => ['label' => 'Section Officer', 'level' => 1, 'value' => 'section_officer'],
        'deputy_secretary' => ['label' => 'Deputy Secretary', 'level' => 2, 'value' => 'deputy_secretary'],
        'joint_secretary' => ['label' => 'Joint Secretary', 'level' => 3, 'value' => 'joint_secretary'],
        'additional_secretary' => ['label' => 'Additional Secretary', 'level' => 4, 'value' => 'additional_secretary'],
        'secretary' => ['label' => 'Secretary', 'level' => 5, 'value' => 'secretary'],
    ];

    foreach (PostType::cases() as $case) {
        $meta = $expected[$case->value] ?? null;
        expect($meta)->not->toBeNull();

        expect($case->label())->toBe($meta['label']);
        expect($case->level())->toBe($meta['level']);
        expect($case->value)->toBe($meta['value']);
    }
});

it('orderedHierarchy returns correct order and increasing levels', function () {
    $order = PostType::orderedHierarchy();

    expect(is_array($order))->toBeTrue();
    expect(count($order))->toBeGreaterThanOrEqual(5);

    $levels = array_map(fn($p) => $p->level(), $order);

    // levels should be strictly increasing
    for ($i = 1; $i < count($levels); $i++) {
        expect($levels[$i])->toBeGreaterThan($levels[$i - 1]);
    }

    // first should be lowest (Section Officer), last highest (Secretary)
    expect($order[0])->toBeInstanceOf(PostType::class);
    expect($order[0])->toBe(PostType::SECTION_OFFICER);
    expect($order[count($order) - 1])->toBe(PostType::SECRETARY);
});
