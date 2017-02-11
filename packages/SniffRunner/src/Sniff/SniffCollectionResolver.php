<?php declare(strict_types=1);

namespace Symplify\EasyCodingStandard\SniffRunner\Sniff;

use Symplify\EasyCodingStandard\SniffRunner\Repository\SniffRepository;
use Symplify\EasyCodingStandard\SniffRunner\Validator\GroupValidator;

final class SniffCollectionResolver
{
    /**
     * @var GroupValidator
     */
    private $standardsOptionResolver;

    /**
     * @var SniffRepository
     */
    private $sniffRepository;

    public function __construct(
        GroupValidator $standardsOptionResolver,
        SniffRepository $sniffRepository
    ) {
        $this->standardsOptionResolver = $standardsOptionResolver;
        $this->sniffRepository = $sniffRepository;
    }

    /**
     * @return string[]
     */
    public function resolve(array $groups, array $sniffs, array $excludedSniffs) : array
    {
        $sniffClasses = [];
        if (count($groups)) {
            $this->standardsOptionResolver->ensureGroupsExist($groups);
            foreach ($groups as $group) {
                $sniffClasses += $this->sniffRepository->getByGroup($group);
            }
        }

        return $sniffClasses;
    }
}