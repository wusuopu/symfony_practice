<?php
namespace Blogger\BlogBundle\Common;

trait LoggerUtil
{
    public function PutAppLog($str, $ctx=[], $level="info")
    {

        if ($this->container->getParameter("kernel.environment") == "dev") {
            ob_start();
            var_dump($str);
            $outStr = ob_get_contents();
            ob_end_clean();
            $this->get('monolog.logger.applog')->$level($outStr, $ctx);
        }
    }

    public function remoteDump($data)
    {
        if ($this->container->has('wusuopu.remote_dump')) {
            $this->container->get('wusuopu.remote_dump')->dump($data);
        }
    }
}
?>
