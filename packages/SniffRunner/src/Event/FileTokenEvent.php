<?php declare(strict_types=1);

namespace Symplify\EasyCodingStandard\SniffRunner\Event;

use PHP_CodeSniffer\Files\File;

final class FileTokenEvent
{
    /**
     * @var File
     */
    private $file;

    /**
     * @var int
     */
    private $position;

    public function __construct(File $file, int $position)
    {
        $this->file = $file;
        $this->position = $position;
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function getPosition(): int
    {
        return $this->position;
    }
}
