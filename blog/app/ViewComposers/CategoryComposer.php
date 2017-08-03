<?php
/**
 * Created by PhpStorm.
 * User: RiskyWorks
 * Date: 03.08.2017
 * Time: 3:43
 */

namespace App\ViewComposers;


use App\Repositories\CategoryRepository;

class CategoryComposer extends ViewComposer
{
    public $categories;

    public function __construct() {
        $this->categories = CategoryRepository::getAll();
    }

    public function compose(\Illuminate\View\View $view) {
        $view->with(['categories' => $this->categories]);
    }
}