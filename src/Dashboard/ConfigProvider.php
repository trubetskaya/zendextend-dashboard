<?php
/**
 * Copyright (c) 2012 Jurian Sluiman.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of the
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package     ZfcAdmin
 * @author      Jurian Sluiman <jurian@soflomo.com>
 * @copyright   2012 Jurian Sluiman.
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link        http://zf-commons.github.com
 */

namespace Dashboard {

    use Zend\Router\Http;
    use Doctrine\ORM\Mapping\Driver;

    /**
     * Class ConfigProvider.
     */
    class ConfigProvider
    {
        /**
         * Provide dependency configuration for an application integrating i18n.
         *
         * @return array
         */
        public function __invoke()
        {
            return [
                'navigation' => $this->getNavigationConfig(),
                'view_manager' => $this->getViewManagerConfig(),
                'zfcadmin' => $this->getModuleConfig(),
                'router' => $this->getRouterConfig(),
            ];
        }

        public function getDoctrineConfig()
        {
            return  [

                // Metadata Mapping driver configuration
                'driver' => [

                    // Configuration for service `doctrine.driver.orm_default` service
                    'zfcuser_entity' => [
                        'class' => Driver\AnnotationDriver::class,
                        'paths' => __DIR__ . '/../../src/Dashboard/Entity'
                    ],

                    // Configuration for service `doctrine.driver.orm_default` service
                    'orm_default' => [

                        // Map of driver names to be used within this driver chain, indexed by entity namespace
                        'drivers' => [
                            'Dashboard\Entity'  => 'zfcuser_entity'
                        ],
                    ],
                ],
            ];
        }

        /**
         * Navigation config
         * @return array
         */
        public function getNavigationConfig()
        {
            return [
                'admin' => [
                    'menu' => [
                        'route' => 'zfcadmin',
                        'ico' => '<i class="fa fa-home"></i>',
                        'label' => 'Dashboard'
                    ],
                    'ecommerce' => [
                        'uri' => 'javascript:;',
                        'label' => 'ECommerce',
                        'ico' => '<i class="fa fa-bar-chart-o"></i>',
                        'pages' => [
                            'list' => [
                                'label' => 'List',
                                'route' => 'zfcadmin/dashboard',
                                'controller' => 'commerce',
                                'action' => 'index',
                            ],

                            'add' => [
                                'label' => 'Add',
                                'route' => 'zfcadmin/dashboard',
                                'controller' => 'commerce',
                                'action' => 'add',
                            ],

                            'edit' => [
                                'label' => 'Edit',
                                'route' => 'zfcadmin/dashboard',
                                'controller' => 'commerce',
                                'action' => 'edit',
                                'params' => ['id' => 0]
                            ]
                        ],
                    ],

                    'landing' => [
                        'route' => 'home',
                        'label' => '<i class="fa fa-laptop"></i>Landing',
                    ],

                    'exit' => [
                        'route' => 'zfcuser/logout',
                        'label' => '<i class="fa fa-power-off"></i>Exit',
                    ],
                ],
            ];
        }

        /**
         * Router config
         * @return array
         */
        public function getRouterConfig()
        {
            return [
                'routes' => [
                    'zfcadmin' => [
                        'type' => Http\Literal::class,
                        'options' => [
                            'route'    => '/dashboard',
                            'defaults' => [
                                'module'    => 'dashboard',
                                'controller' => Controller\IndexController::class,
                                'action'     => 'index',
                            ],
                        ],

                        'child_routes' => [
                            'dashboard' => [
                                'type' => Http\Segment::class,
                                'options' => [
                                    'route' => '/:controller[/:action[/:id]]',
                                    'constraints' => [
                                        'controller'    => '[a-zA-Z][a-zA-Z0-9_-]+',
                                        'action'        => '[a-zA-Z][a-zA-Z0-9_-]+',
                                        'id'            => '[0-9]+'
                                    ],
                                    'defaults' => [
                                        'controller'    => Controller\IndexController::class,
                                        'action'        => 'index',
                                    ],
                                ],
                            ],
                        ]
                    ],
                ],
            ];
        }

        /**
         * @return array
         */
        public function getViewManagerConfig()
        {
            return [
                'not_found_template'       => 'error/404',
                'exception_template'       => 'error/index',

                'template_map' => [
                    'error/404'         => __DIR__ . '/../../view/error/404.phtml',
                    'error/index'       => __DIR__ . '/../../view/error/500.phtml',
                    'error/403'         => __DIR__ . '/../../view/error/403.phtml',
                ],

                'template_path_stack' => [
                    'zfcuser' => __DIR__ . '/../../view/dashboard',
                    __NAMESPACE__ => __DIR__ . '/../../view',
                ],
            ];
        }

        /**
         * @return array
         */
        public function getModuleConfig()
        {
            return [
                'use_admin_layout' => true,
                'admin_layout_template' => 'layout/dashboard',
            ];
        }
    }
}
