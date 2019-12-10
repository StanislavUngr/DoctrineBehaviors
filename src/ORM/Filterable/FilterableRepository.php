<?php

declare(strict_types=1);

/*
 * This file is part of the KnpDoctrineBehaviors package.
 *
 * (c) KnpLabs <http://knplabs.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Knp\DoctrineBehaviors\ORM\Filterable;

use Doctrine\ORM\QueryBuilder;

/**
 * Filterable trait.
 *
 * Should be used inside entity repository, that needs to be filterable
 */
trait FilterableRepository
{
    /**
     * Retrieve field which will be sorted using LIKE
     *
     * Example format: ['e:name', 'e:description']
     */
    abstract public function getLikeFilterColumns(): array;

    /**
     * Retrieve field which will be sorted using LOWER() LIKE
     *
     * Example format: ['e:name', 'e:description']
     */
    abstract public function getILikeFilterColumns(): array;

    /**
     * Retrieve field which will be sorted using EQUAL
     *
     * Example format: ['e:name', 'e:description']
     */
    abstract public function getEqualFilterColumns(): array;

    /**
     * Retrieve field which will be sorted using IN()
     *
     * Example format: ['e:group_id']
     */
    abstract public function getInFilterColumns(): array;

    /**
     * Filter values
     *
     * @param  array                      $filters - array like ['e:name' => 'nameValue'] where "e" is entity alias query, so we can filter using joins.
     */
    public function filterBy(array $filters, ?QueryBuilder $qb = null): \Doctrine\ORM\QueryBuilder
    {
        $filters = array_filter($filters, function ($filter) {
            return ! empty($filter);
        });

        if ($qb === null) {
            $qb = $this->createFilterQueryBuilder();
        }

        foreach ($filters as $col => $value) {
            foreach ($this->getColumnParameters($col) as $colName => $colParam) {
                $compare = $this->getWhereOperator($col) . 'Where';

                if (in_array($col, $this->getLikeFilterColumns(), true)) {
                    $qb
                        ->{$compare}(sprintf('%s LIKE :%s', $colName, $colParam))
                        ->setParameter($colParam, '%' . $value . '%')
                    ;
                }

                if (in_array($col, $this->getILikeFilterColumns(), true)) {
                    $qb
                        ->{$compare}(sprintf('LOWER(%s) LIKE :%s', $colName, $colParam))
                        ->setParameter($colParam, '%' . strtolower($value) . '%')
                    ;
                }

                if (in_array($col, $this->getEqualFilterColumns(), true)) {
                    $qb
                        ->{$compare}(sprintf('%s = :%s', $colName, $colParam))
                        ->setParameter($colParam, $value)
                    ;
                }

                if (in_array($col, $this->getInFilterColumns(), true)) {
                    $qb
                        ->{$compare}($qb->expr()->in(sprintf('%s', $colName), (array) $value))
                    ;
                }
            }
        }

        return $qb;
    }

    protected function getColumnParameters($col)
    {
        $colName = str_replace(':', '.', $col);
        $colParam = str_replace(':', '_', $col);

        return [$colName => $colParam];
    }

    protected function getWhereOperator($col)
    {
        return 'and';
    }

    protected function createFilterQueryBuilder()
    {
        return $this->createQueryBuilder('e');
    }
}
