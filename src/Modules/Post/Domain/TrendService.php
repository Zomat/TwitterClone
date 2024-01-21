<?php declare(strict_types=1);

namespace Modules\Post\Domain;

class TrendService
{
    public function __construct(
        private ITrendRepository $repository
    ) {}

    public function saveFromContent(string $content)
    {
        $pattern = '/#\w+/';
        preg_match_all($pattern, $content, $matches);

        if (!empty($matches[0])) {
            foreach ($matches[0] as $hashtag) {
                $this->repository->add(ltrim($hashtag, '#'));
            }
        }
    }
}
