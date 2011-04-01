<?php

/*
 * This file is part of the Sonata project.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Sonata\OrderBundle\Entity;

use Sonata\Component\Order\OrderManagerInterface;
use Sonata\Component\Order\OrderInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class OrderManager implements OrderManagerInterface
{
    protected $em;
    protected $repository;
    protected $class;
    
    public function __construct(EntityManager $em, $class)
    {
        $this->em    = $em;
        $this->class = $class;

        if(class_exists($class)) {
            $this->repository = $this->em->getRepository($class);
        }
    }

    /**
     * Creates an empty medie instance
     *
     * @return Order
     */
    public function createOrder()
    {
        $class = $this->class;

        return new $class;
    }

    /**
     * Updates a order
     *
     * @param Order $order
     * @return void
     */
    public function updateOrder(OrderInterface $order)
    {
        $this->em->persist($order);
        $this->em->flush();
    }

    /**
     * Returns the order's fully qualified class name
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Finds one order by the given criteria
     *
     * @param array $criteria
     * @return Order
     */
    public function findOrderBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * Deletes a order
     *
     * @param Order $order
     * @return void
     */
    public function deleteOrder(OrderInterface $order)
    {
        $this->em->remove($order);
        $this->em->flush();
    }
}