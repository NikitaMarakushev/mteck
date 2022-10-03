<?php

namespace App\Core\Infrastructure\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class IconExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('icon', [$this, 'formatIcon'])
        ];
    }

    public function formatIcon(string $text): string
    {
        // silver => {{silver}} => icon-silver.png
        $tags = ['silver', 'gold', 'first', 'second', 'unique', 'tap', 'instant', 'counter', 'health', 'move', 'fly',
            'regen', 'uchr', 'direct', 'strike', 'zoz', 'zome', 'zom', 'zov', 'zovd', 'zor', 'zoo', ];

        $search = [];
        $replace = [];

        foreach ($tags as $tag) {
            $search[] = '{{'.$tag.'}}';
            $replace[] = '<img src="/images/icon-'.$tag.'.png" class="img-fluid" alt="'.$tag.'">';
        }

        return str_replace($search, $replace, $text);
    }
}