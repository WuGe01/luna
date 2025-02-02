<?php

/**
 * Part of starter project.
 *
 * @copyright  Copyright (C) 2021 __ORGANIZATION__.
 * @license    MIT
 */

declare(strict_types=1);

namespace Lyrasoft\Luna\Module\Admin\Article;

use Lyrasoft\Luna\Entity\Article;
use Lyrasoft\Luna\Locale\LanguageAssocTrait;
use Lyrasoft\Luna\Module\Admin\Article\Form\EditForm;
use Lyrasoft\Luna\Repository\ArticleRepository;
use Lyrasoft\Luna\Services\TagService;
use Unicorn\Controller\CrudController;
use Unicorn\Controller\GridController;
use Windwalker\Core\Application\AppContext;
use Windwalker\Core\Attributes\Controller;
use Windwalker\Core\Router\Navigator;
use Windwalker\DI\Attributes\Autowire;
use Windwalker\ORM\Event\AfterSaveEvent;

/**
 * The ContentController class.
 */
#[Controller()]
class ArticleController
{
    use LanguageAssocTrait;

    public function save(
        AppContext $app,
        CrudController $controller,
        Navigator $nav,
        #[Autowire] ArticleRepository $repository,
        TagService $tagService,
    ): mixed {
        $form = $app->make(EditForm::class);

        $controller->afterSave(
            function (AfterSaveEvent $event) use ($tagService, $repository, $app) {
                /** @var Article $entity */
                $entity = $event->getEntity();

                $tagService->flushTagMapsFromInput(
                    'article',
                    $entity->getId(),
                    (array) ($app->input('item')['tags'] ?? [])
                );

                if ($this->localeService->isEnabled()) {
                    $this->saveLangAssociations(
                        'article',
                        $entity->getLanguage(),
                        $entity->getId(),
                        $app->input('item')['assoc'] ?? []
                    );
                }
            }
        );

        $uri = $app->call([$controller, 'save'], compact('repository', 'form'));

        switch ($app->input('task')) {
            case 'save2close':
                return $nav->to('article_list');

            case 'save2new':
                return $nav->to('article_edit')->var('new', 1);

            case 'save2copy':
                $controller->rememberForClone($app, $repository);

                return $nav->self($nav::WITHOUT_VARS)->var('new', 1);

            default:
                return $uri;
        }
    }

    public function delete(
        AppContext $app,
        #[Autowire] ArticleRepository $repository,
        CrudController $controller
    ): mixed {
        return $app->call([$controller, 'delete'], compact('repository'));
    }

    public function filter(
        AppContext $app,
        #[Autowire] ArticleRepository $repository,
        GridController $controller
    ): mixed {
        return $app->call([$controller, 'filter'], compact('repository'));
    }

    public function batch(
        AppContext $app,
        #[Autowire] ArticleRepository $repository,
        GridController $controller
    ): mixed {
        $data = match ($app->input('task')) {
            'publish' => ['state' => 1],
            'unpublish' => ['state' => 0],
            default => null
        };

        return $app->call([$controller, 'batch'], compact('repository', 'data'));
    }

    public function copy(
        AppContext $app,
        #[Autowire] ArticleRepository $repository,
        GridController $controller
    ): mixed {
        return $app->call([$controller, 'copy'], compact('repository'));
    }
}
