<?php
/*
 * This file is part of the ByscriptsManagerBundle package.
 *
 * (c) Thierry Goettelmann <thierry@byscripts.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Byscripts\ObjectManager\Manager;

use Byscripts\ObjectManager\Exception\ObjectManagerException;

/**
 * Class AbstractManager
 *
 * @author Thierry Goettelmann <thierry@byscripts.info>
 */
abstract class AbstractObjectManager
{
    /**
     * Execute an action
     *
     * @param string $action
     * @param mixed  ...$data One or more arguments to pass to the process method
     *
     * @throws \Exception
     * @return bool
     */
    public function execute($action, $data)
    {
        $data = array_slice(func_get_args(), 1);

        try {
            $data[] = $this->callProcessMethod($action, $data);
            $this->callSuccessMethod(
                $action,
                $data
            );

            return true;
        } catch (ObjectManagerException $exception) {
            $data[] = $exception->getMessage();
            $this->callErrorMethod(
                $action,
                $data
            );

            return false;
        }
    }

    protected function callProcessMethod($action, array $data)
    {
        $name = 'process' . ucfirst($action);

        if (!method_exists($this, $name)) {
            throw new \Exception(sprintf('Method not found: %s in class %s', $name, get_called_class()));
        }

        return call_user_func_array(array($this, $name), $data);
    }

    protected function callSuccessMethod($action, array $data)
    {
        $name = 'on' . ucfirst($action) . 'Success';

        if (method_exists($this, $name)) {
            return call_user_func_array(array($this, $name), $data);
        }
    }

    protected function callErrorMethod($action, array $data)
    {
        $name = 'on' . ucfirst($action) . 'Error';

        if (method_exists($this, $name)) {
            return call_user_func_array(array($this, $name), $data);
        }
    }
}
