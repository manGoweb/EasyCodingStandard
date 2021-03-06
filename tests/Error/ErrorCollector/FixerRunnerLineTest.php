<?php declare(strict_types=1);

namespace Symplify\EasyCodingStandard\Tests\Error\ErrorCollector;

use PHPUnit\Framework\TestCase;
use SplFileInfo;
use Symplify\EasyCodingStandard\ChangedFilesDetector\ChangedFilesDetector;
use Symplify\EasyCodingStandard\DependencyInjection\ContainerFactory;
use Symplify\EasyCodingStandard\Error\Error;
use Symplify\EasyCodingStandard\Error\ErrorCollector;
use Symplify\EasyCodingStandard\FixerRunner\Application\FixerFileProcessor;

final class FixerRunnerLineTest extends TestCase
{
    /**
     * @var ErrorCollector
     */
    private $errorDataCollector;

    /**
     * @var FixerFileProcessor
     */
    private $fileProcessor;

    protected function setUp(): void
    {
        $container = (new ContainerFactory)->createWithConfig(
            __DIR__ . '/FixerRunnerSource/easy-coding-standard.neon'
        );

        $this->errorDataCollector = $container->get(ErrorCollector::class);
        $this->fileProcessor = $container->get(FixerFileProcessor::class);

        /** @var ChangedFilesDetector $changedFilesDetector */
        $changedFilesDetector = $container->get(ChangedFilesDetector::class);
        $changedFilesDetector->clearCache();
    }

    public function test(): void
    {
        $this->runFileProcessor();

        $this->assertSame(1, $this->errorDataCollector->getErrorCount());

        $errorMessages = $this->errorDataCollector->getAllErrors();

        /** @var Error $error */
        $error = array_pop($errorMessages)[0];
        $this->assertInstanceOf(Error::class, $error);

        $this->assertSame(8, $error->getLine());
    }

    private function runFileProcessor(): void
    {
        $fileInfo = new SplFileInfo(__DIR__ . '/ErrorCollectorSource/ConstantWithoutPublicDeclaration.php.inc');

        $this->fileProcessor->processFile($fileInfo);
    }
}
