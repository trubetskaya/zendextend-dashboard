<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.08.14
 * Time: 17:43
 */

namespace Dashboard\Controller {

    use Lib\Controller\AbstractController;
    use Lib\Entity\Document;
    use Lib\Entity\File;
    use Lib\Service\DocumentService;
    use Dashboard\Entity\ECommerceProduct;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Criteria;
    use Doctrine\ORM\EntityNotFoundException;
    use Zend\Mvc\MvcEvent;
    use Zend\View\Model\JsonModel;
    use Zend\View\Model\ViewModel;

    /**
     * Товары (commerce)
     * @package Commerce\Controller
     *
     * @property DocumentService $service
     * @method DocumentService getService()
     */
    class CommerceController extends AbstractController
    {
        /**
         * Function onDispatch
         * @param MvcEvent $e
         * @return mixed
         */
        public function onDispatch(MvcEvent $e)
        {
            $this->service = new DocumentService;
            $this->service->setServiceLocator($e->getApplication()->getServiceManager());

            return parent::onDispatch($e);
        }

        /**
         * Entity class name
         * @var string
         */
        protected static $entityClass = ECommerceProduct::class;

        /**
         * Список файлов товара
         * @return JsonModel|ViewModel
         */
        public function getFilesAction()
        {
            /** @var Document $document */
            $document = $this->getEntityManager()->getRepository(self::$entityClass)
                ->find(intval($this->params()->fromRoute("id")));

            $attachment = [];
            if ($document instanceof self::$entityClass) {
                /** @var File $file */
                foreach ($document->getFiles() as $file) {
                    $attachment[$file->getIndex()] = array_merge(
                        $file->toArray(),
                        [
                            'thumbnail' => $file->getPreview(),
                            'status' => 'success'
                        ]
                    );
                }
            }

            return new JsonModel([
                'status' => 'success',
                'data' => [
                    'message' => 'Changes applied successful',
                    'files' => $attachment
                ]
            ]);
        }

        /**
         * Сортировка файлов товара
         * @return JsonModel|ViewModel
         * @throws \Lib\Mvc\Exception\InvalidArgumentException
         */
        public function sortFilesAction()
        {
            try {
                /** @var ECommerceProduct $document */
                $document = $this->getEntityManager()->getRepository(self::$entityClass)
                    ->find(intval($this->params()->fromRoute("id")));
                if (!$document instanceof Document) {
                    throw new EntityNotFoundException;
                }

                /** @var ArrayCollection $collection */
                $collection = $document->getFiles();

                $post = $this->getRequest()->getPost();
                $matching = $collection->matching(
                    Criteria::create()->setMaxResults(1)->where(
                        Criteria::expr()->eq('id', $post->id)
                    )
                );

                $target = $matching->first();
                if (!$target instanceof File) {
                    throw new EntityNotFoundException;
                }

                $pos = $collection->indexOf($target) + $post->offset;
                $target->setIndex(
                    $collection->get($pos)
                        ->getIndex()
                );

                $k = pow(-1, intval($post->offset > 0));
                $offset = abs($post->offset);
                while (--$offset >= 0) {
                    /** @var File $item */
                    $item = $document->getFiles()->get($offset * $k + $pos);
                    $item->setIndex($k * ($offset + 1) + $target->getIndex());

                    $attachment[$item->getIndex()] = $item->getId();
                    $this->getEntityManager()->persist($item);
                }

                $attachment[$target->getIndex()] = $target->getId();
                $this->getEntityManager()->persist($target);
                $this->getEntityManager()->flush();

                return new JsonModel([
                    'status' => 'success',
                    'data' => $attachment
                ]);
            } catch (\Exception $ex) {

                return new JsonModel([
                    'status' => 'error',
                    'data' => [
                        'message' => $ex->getMessage()
                    ]
                ]);
            }
        }

        /**
         * Remove document file
         * @throws EntityNotFoundException
         * @return JsonModel
         */
        public function removeFileAction()
        {
            try {
                $em = $this->getEntityManager();
                $file = $em->getRepository(File::class)->find(
                    intval($this->params()->fromPost("id"))
                );

                if (!$file instanceof File) {
                    throw new EntityNotFoundException;
                }

                $em->remove($file);
                $em->flush();

                return new JsonModel([
                    'status' => 'success',
                    'data' => [
                        'message' => 'Changes applied successful',
                        'hash' => $file->getHash()
                    ]
                ]);

            } catch (\Exception $ex) {

                return new JsonModel([
                    'status' => 'error',
                    'data' => [
                        'message' => $ex->getMessage()
                    ]
                ]);
            }
        }
    }
}