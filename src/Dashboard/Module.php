<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Dashboard {

    use Zend\Mvc\MvcEvent;
    use Zend\Mvc\ModuleRouteListener;
    use Zend\Loader\AutoloaderFactory;
    use Zend\Loader\StandardAutoloader;
    use Zend\ServiceManager\Factory\InvokableFactory;
    use ZfcRbac\View\Strategy\UnauthorizedStrategy;


    /**
     * Dashboard module
     * @package Dashboard
     */
    class Module
    {
        /**
         * Bootstrap
         * @param MvcEvent $event
         */
        public function onBootstrap(MvcEvent $event)
        {
            $em = $event->getApplication()->getEventManager();
            $em->attach(MvcEvent::EVENT_ROUTE, function (MvcEvent $e) {
                $rm = $e->getRouteMatch();
                if ($rm->getParam('controller') == 'zfcuser' && $rm->getParam('action') == 'login') {
                    $e->getViewModel()->setTemplate('layout/empty');
                }
            });

            $routeListener = new ModuleRouteListener();
            $routeListener->attach($em);

            $sm = $event->getApplication()->getServiceManager();
            $listener = $sm->get(UnauthorizedStrategy::class);
            $listener->attach($em);
        }

        /**
         * Autoloader
         * @return array
         */
        public function getAutoloaderConfig()
        {
            return [
                AutoloaderFactory::STANDARD_AUTOLOADER => [
                    StandardAutoloader::LOAD_NS => [
                        __NAMESPACE__ => __DIR__,
                    ],
                ],
            ];
        }

        /**
         * Get module config
         * @return array
         */
        public function getConfig()
        {
            $provider = new ConfigProvider();

            return array_merge_recursive(
                include __DIR__ . '/../../../zendextend/config/module.config.php',
                [
                    'router' => $provider->getRouterConfig(),
                    'zfcadmin' => $provider->getModuleConfig(),
                    'doctrine' => $provider->getDoctrineConfig(),
                    'navigation' => $provider->getNavigationConfig(),
                    'view_manager' => $provider->getViewManagerConfig(),
                    'controllers' => [
                        'aliases' => [
                            'index' => Controller\IndexController::class,
                            'commerce' => Controller\CommerceController::class,
                        ],

                        'factories' => [
                            Controller\IndexController::class => InvokableFactory::class,
                            Controller\CommerceController::class => InvokableFactory::class,
                        ]
                    ],
                ]
            );
        }
    }
}
