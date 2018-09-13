<?php

namespace Flyke\TemplateHints;

use File;

class TemplateHints
{
    /**
     * [$files description].
     * @var [type]
     */
    protected $files;

    /**
     * [$realPath description].
     * @var [type]
     */
    protected $realPath;

    /**
     * [$debug description].
     * @var [type]
     */
    protected $debug;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->files = File::allFiles(base_path().(config('templatehints.path', '/storage/framework/views')));
        $this->realPath = '<!-- Template file: <?php echo str_replace("'.base_path().'", "", last($this->lastCompiled)) ?> -->';
        $this->realPath .= "\n";
        $this->debug = config('templatehints.trace');
    }

    /**
     * Start the tracer.
     * @return [type] [description]
     */
    public function trace()
    {
        foreach ($this->files as $file) {
            ($this->debug === true) ? $this->addTrace($file) : $this->removeTrace($file);
        }
    }

    /**
     * Add the trace to the view.
     * @param [type] $file [description]
     */
    public function addTrace($file)
    {
        // If the file does not contain the trace, add it.
        if (strpos(File::get($file), $this->realPath) === false && $this->debug == true) {
            File::prepend($file, $this->realPath);
        }
    }

    /**
     * Remove the trace from the view.
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
    public function removeTrace($file)
    {
        // If the file does contain the trace, remove it.
        if (strpos(File::get($file), $this->realPath) !== false) {
            $content = str_replace($this->realPath, '', File::get($file));
            File::put($file, $content);
        }
    }
}
