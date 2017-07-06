<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Dashboard\Controller {

    use Zend\Mvc\Controller\AbstractActionController;
    use Zend\View\Model\JsonModel;

    /**
     * Class IndexController
     * @package Dashboard\Controller
     */
    class IndexController extends AbstractActionController
    {
        /**
         * Function indexAction
         * @return array
         */
        public function indexAction()
        {
            return [];
        }

        /**
         * Function indexAction
         * @return JsonModel
         */
        public function index2Action()
        {
            return new JsonModel(['ok']);
        }
    }
}
