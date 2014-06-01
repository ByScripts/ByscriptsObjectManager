<?php


namespace Byscripts\ObjectManager\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

abstract class AbstractDoctrineObjectManager extends AbstractObjectManager
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $doctrineObjectManager;

    /**
     * @param ObjectManager $objectManager
     */
    public function setDoctrineObjectManager(ObjectManager $objectManager)
    {
        $this->doctrineObjectManager = $objectManager;
    }

    /**
     * @return ObjectRepository
     */
    abstract public function getRepository();

    /**
     * Alias to repository find method
     *
     * @param string    $id
     * @param int|mixed $lockMode
     * @param null      $lockVersion
     *
     * @return null|object
     */
    public function find($id, $lockMode = 0, $lockVersion = null)
    {
        return $this->getRepository()->find($id, $lockMode, $lockVersion);
    }

    /**
     * Alias to repository findAll method
     *
     * @return array
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * Alias to repository findBy method
     *
     * @param array $criteria
     * @param array $orderBy
     * @param null  $limit
     * @param null  $offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Alias to repository findOneBy method
     *
     * @param array $criteria
     * @param array $orderBy
     *
     * @return null|object
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->getRepository()->findOneBy($criteria, $orderBy);
    }

    /**
     * Alias to object manager persist method
     *
     * @param $object
     *
     * @return $this
     */
    public function persist($object)
    {
        $this->doctrineObjectManager->persist($object);

        return $this;
    }

    /**
     * Alias to object manager remove method
     *
     * @param $object
     *
     * @return $this
     */
    public function remove($object)
    {
        $this->doctrineObjectManager->remove($object);

        return $this;
    }

    /**
     * Alias to object manager flush method
     *
     * @return $this
     */
    public function flush()
    {
        $this->doctrineObjectManager->flush();
    }

    /**
     * @param $object
     */
    public function persistAndFlush($object)
    {
        $this->persist($object)->flush();
    }

    /**
     * @param $object
     */
    public function removeAndFlush($object)
    {
        $this->remove($object)->flush();
    }

    /**
     * Save the object to the database
     *
     * @param object $object
     *
     * @return bool
     */
    public function save($object)
    {
        $this->execute('save', $object, !(bool)$object->getId());
    }

    /**
     * Delete the object from the database
     *
     * @param object $object
     *
     * @return bool
     */
    public function delete($object)
    {
        return $this->execute('delete', $object);
    }

    /**
     * Duplicate the object
     *
     * @param object $object The object to duplicate
     *
     * @return object|false The new object
     */
    public function duplicate($object)
    {
        return $this->execute('duplicate', $object);
    }

    /**
     * Activate the object
     *
     * @param object $object The object to activate
     *
     * @return bool
     */
    public function activate($object)
    {
        return $this->execute('activate', $object);
    }

    /**
     * Deactivate the object
     *
     * @param object $object The object to deactivate
     *
     * @return bool
     */
    public function deactivate($object)
    {
        return $this->execute('deactivate', $object);
    }

    /**
     * @param object $object
     */
    protected function processSave($object, $isNew)
    {
        $this->persistAndFlush($object);
    }

    /**
     * @param object $object
     */
    protected function processDelete($object)
    {
        $this->removeAndFlush($object);
    }

    /**
     * @param object $object
     *
     * @return mixed
     */
    protected function processDuplicate($object)
    {
        $clone = clone $object;
        $this->persistAndFlush($clone);

        return $clone;
    }

    /**
     * @param object $object
     */
    protected function processActivate($object)
    {
        $object->setActive(true);
        $this->persistAndFlush($object);
    }

    /**
     * @param object $object
     */
    protected function processDeactivate($object)
    {
        $object->setActivate(false);
        $this->persistAndFlush($object);
    }
}
