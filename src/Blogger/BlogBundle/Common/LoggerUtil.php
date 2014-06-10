<?php
namespace Blogger\BlogBundle\Common;

trait LoggerUtil
{
    public function PutAppLog($str, $ctx=[], $level="info")
    {

        if ($this->container->getParameter("kernel.environment") == "dev") {
            $this->get('monolog.logger.applog')->$level($str, $ctx);
        }
    }
}
?>
