<?php

/**
 * Part of earth project.
 *
 * @copyright  Copyright (C) 2021 __ORGANIZATION__.
 * @license    MIT
 */

declare(strict_types=1);

namespace Lyrasoft\Luna\Services;

use Lyrasoft\Luna\Entity\Tag;
use Lyrasoft\Luna\Entity\TagMap;
use ReflectionException;
use Windwalker\Database\Driver\StatementInterface;
use Windwalker\ORM\EntityMapper;
use Windwalker\ORM\ORM;
use Windwalker\Utilities\Str;

/**
 * The TagService class.
 */
class TagService
{
    protected string $newTagPrefix = 'new#';

    public function __construct(protected ORM $orm)
    {
    }

    public function createTagsIfNew(iterable $tagIds): array
    {
        $r = [];

        /** @var EntityMapper<Tag> $mapper */
        $mapper = $this->orm->mapper(Tag::class);

        foreach ($tagIds as $i => $tagId) {
            if (str_starts_with((string) $tagId, $this->getNewTagPrefix())) {
                $tagTitle = Str::removeLeft((string) $tagId, 'new#');

                $tag = $mapper->createOne(
                    [
                        'title' => $tagTitle,
                        'state' => 1,
                    ]
                );

                $r[$i] = (string) $tag->getId();
            } else {
                $r[$i] = $tagId;
            }
        }

        return $r;
    }

    /**
     * flushTags
     *
     * @param  string    $type
     * @param  mixed     $targetId
     * @param  iterable  $tagIds
     *
     * @return  iterable<TagMap>
     *
     * @throws ReflectionException
     */
    public function flushTagMapsFromInput(string $type, mixed $targetId, iterable $tagIds): iterable
    {
        $tagIds = $this->createTagsIfNew($tagIds);

        return $this->flushTagMaps($type, $targetId, $tagIds);
    }

    /**
     * flushTags
     *
     * @param  string    $type
     * @param  mixed     $targetId
     * @param  iterable  $tagIds
     *
     * @return  iterable<TagMap>
     *
     * @throws ReflectionException
     */
    public function flushTagMaps(string $type, mixed $targetId, iterable $tagIds): iterable
    {
        /** @var EntityMapper<TagMap> $tagMapMapper */
        $tagMapMapper = $this->orm->mapper(TagMap::class);
        $maps = [];

        foreach ($tagIds as $tagId) {
            $map = $tagMapMapper->createEntity();
            $map->setType('article');
            $map->setTagId((int) $tagId);
            $map->setTargetId($targetId);

            $maps[] = $map;
        }

        return $tagMapMapper->flush($maps, ['target_id' => $targetId, 'type' => $type]);
    }

    /**
     * @param  string  $type
     * @param  mixed   $targetId
     *
     * @return  array<StatementInterface>
     *
     * @throws ReflectionException
     */
    public function clearMapsOfTarget(string $type, mixed $targetId): array
    {
        /** @var EntityMapper<TagMap> $tagMapMapper */
        $tagMapMapper = $this->orm->mapper(TagMap::class);

        return $tagMapMapper->deleteWhere(
            [
                'type' => $type,
                'target_id' => $targetId,
            ]
        );
    }

    public function clearMapsOfTag(string $type, mixed $tagId): array
    {
        /** @var EntityMapper<TagMap> $tagMapMapper */
        $tagMapMapper = $this->orm->mapper(TagMap::class);

        return $tagMapMapper->deleteWhere(
            [
                'type' => $type,
                'tag_id' => $tagId,
            ]
        );
    }

    /**
     * @return string
     */
    public function getNewTagPrefix(): string
    {
        return $this->newTagPrefix;
    }

    /**
     * @param  string  $newTagPrefix
     *
     * @return  static  Return self to support chaining.
     */
    public function setNewTagPrefix(string $newTagPrefix): static
    {
        $this->newTagPrefix = $newTagPrefix;

        return $this;
    }
}
