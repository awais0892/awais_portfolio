<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $title = Str::headline(fake()->unique()->words(3, true));

        return [
            'title' => $title,
            'description' => fake()->paragraph(),
            'long_description' => fake()->paragraphs(2, true),
            'image' => null,
            'image_url' => null,
            'fallback_image_url' => null,
            'technologies' => fake()->randomElements(
                ['Laravel', 'PHP', 'Tailwind CSS', 'MySQL', 'Redis', 'Vue', 'React'],
                fake()->numberBetween(2, 4)
            ),
            'live_url' => fake()->boolean(60) ? fake()->url() : null,
            'github_url' => sprintf('https://github.com/example/%s', Str::slug($title)),
            'featured' => fake()->boolean(30),
            'order' => fake()->numberBetween(0, 25),
            'is_active' => fake()->boolean(85),
        ];
    }
}
