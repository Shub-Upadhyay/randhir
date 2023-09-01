<?php

namespace IdeHelper\Test\TestCase\Annotator\ClassAnnotatorTask;

use Cake\Console\ConsoleIo;
use IdeHelper\Annotator\AbstractAnnotator;
use IdeHelper\Annotator\ClassAnnotatorTask\FormClassAnnotatorTask;
use IdeHelper\Console\Io;
use Shim\TestSuite\ConsoleOutput;
use Shim\TestSuite\TestCase;

class FormClassAnnotatorTaskTest extends TestCase {

	/**
	 * @var \Shim\TestSuite\ConsoleOutput
	 */
	protected $out;

	/**
	 * @var \Shim\TestSuite\ConsoleOutput
	 */
	protected $err;

	/**
	 * @var \IdeHelper\Console\Io
	 */
	protected $io;

	/**
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();

		$this->out = new ConsoleOutput();
		$this->err = new ConsoleOutput();
		$consoleIo = new ConsoleIo($this->out, $this->err);
		$this->io = new Io($consoleIo);
	}

	/**
	 * @return void
	 */
	public function testShouldRun() {
		$task = $this->getTask('');

		$content = 'namespace TestApp\\Foo' . PHP_EOL . 'use TestApp\\Form\\DocForm' . PHP_EOL . '$docForm->execute()';
		$result = $task->shouldRun('/src/Foo.php', $content);
		$this->assertTrue($result);

		$result = $task->shouldRun('/tests/Foo.php', $content);
		$this->assertFalse($result);
	}

	/**
	 * @return void
	 */
	public function testAnnotate() {
		$content = file_get_contents(TEST_FILES . 'FormAnnotation' . DS . 'FormAnnotation.missing.php');
		$task = $this->getTask($content);
		$path = '/src/Foo/Foo.php';

		$result = $task->annotate($path);
		$this->assertTrue($result);

		$content = $task->getContent();
		$this->assertTextContains('* @uses \TestApp\Form\DocForm::_execute()', $content);

		$output = $this->out->output();
		$this->assertTextContains('  -> 1 annotation added.', $output);
	}

	/**
	 * @return void
	 */
	public function testAnnotateExisting() {
		$content = file_get_contents(TEST_FILES . 'FormAnnotation' . DS . 'FormAnnotation.existing.php');
		$task = $this->getTask($content);
		$path = '/src/Foo/Foo.php';

		$result = $task->annotate($path);
		$this->assertFalse($result);

		$content = $task->getContent();
		$count = substr_count($content, '@uses');
		$this->assertSame(1, $count);

		$output = $this->out->output();
		$this->assertSame('', $output);
	}

	/**
	 * @param string $content
	 * @param array $params
	 *
	 * @return \IdeHelper\Annotator\ClassAnnotatorTask\FormClassAnnotatorTask
	 */
	protected function getTask(string $content, array $params = []) {
		$params += [
			AbstractAnnotator::CONFIG_DRY_RUN => true,
			AbstractAnnotator::CONFIG_VERBOSE => true,
		];

		return new FormClassAnnotatorTask($this->io, $params, $content);
	}

}
