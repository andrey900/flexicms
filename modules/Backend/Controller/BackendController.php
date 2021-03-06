<?php
/**
 * This file is part of the FlexiCMS (https://flexicms.org)
 * Copyright (c) 2017 Artem Melnik (https://artemmelnik.com)
 */

declare(strict_types=1);

namespace Modules\Backend\Controller;

use Flexi;
use Flexi\Template\View;
use Modules\Backend\Model\ResourceType as ResourceTypeModel;

/**
 * Class BackendController
 * @package Modules\Backend\Controller
 */
class BackendController extends \Controller
{
    /**
     * BackendController constructor.
     */
    public function __construct()
    {
        if (!Flexi\Auth\Auth::authorized()) {
            Flexi\Http\Redirect::go('/backend/login/');
        }

        Flexi\Localization\I18n::instance()
            ->load('dashboard/main', 'Backend')
            ->load('dashboard/menu', 'Backend');

        $resourceTypeModel = new ResourceTypeModel();

        $this->setData('navigation', \Customize::instance()->getAdminMenuItems());
        $this->setData('resourcesType', $resourceTypeModel->getResourcesType());
    }

    /**
     * @return View
     */
    public function dashboard()
    {
        return View::make('dashboard', $this->data);
    }

    public function logout()
    {
        Flexi\Auth\Auth::unauthorize();
        Flexi\Http\Redirect::go('/backend/login/');
    }
}
