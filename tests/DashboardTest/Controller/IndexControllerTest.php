<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace DashboardTest\Controller {

    use Zend\Stdlib\ArrayUtils;
    use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
    use Dashboard\Controller\IndexController;

    /**
     * Class IndexControllerTest
     * @package DashboardTest\Controller
     */
    class IndexControllerTest extends AbstractHttpControllerTestCase
    {
        /**
         * Function setUp
         */
        public function setUp()
        {
            // The module configuration should still be applicable for tests.
            // You can override configuration here with test case specific values,
            // such as sample view templates, path stacks, module_listener_options,
            // etc.
            $configOverrides = [];

            $this->setApplicationConfig(ArrayUtils::merge(
                include __DIR__ . '/../../../../config/application.config.php',
                $configOverrides
            ));

            parent::setUp();
        }

        /**
         * Function testIndexActionCanBeAccessed
         */
        public function testIndexActionCanBeAccessed()
        {
            $this->dispatch('/dashboard', 'GET');
            $this->assertResponseStatusCode(200);
            $this->assertModuleName('dashboard');
            $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
            $this->assertControllerClass('IndexController');
            $this->assertMatchedRouteName('dashboard');
        }

        /**
         * Function testIndexActionViewModelTemplateRenderedWithinLayout
         */
        public function testIndexActionViewModelTemplateRenderedWithinLayout()
        {
            $this->dispatch('/dashboard', 'GET');
            $this->assertQuery('Dashboard');
        }

        /**
         * Function testInvalidRouteDoesNotCrash
         */
        public function testInvalidRouteDoesNotCrash()
        {
            $this->dispatch('/dashboard/invalid/route', 'GET');
            $this->assertResponseStatusCode(500);
        }
    }
}
