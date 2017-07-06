<?php
/**
 * Created by PhpStorm.
 * Date: 06.05.16
 * Time: 23:28
 */

namespace Dashboard\Entity {

    use Doctrine\ORM\Mapping as ORM;
    use Zend\Form\Annotation as Form;
    
    /**
     * Trait ECommerceProductTrait
     * @package Dashboard\Entity
     */
    trait ECommerceProductTrait
    {
        /**
         * @var float
         * @Form\Type("Number")
         * @Form\Flags({"priority": 44})
         * @Form\Options({"label": "Price:"})
         * @Form\Attributes({
         *      "data-parsley-required": "true",
         *      "data-parsley-required-message": "Price cant be empty",
         *
         *      "data-parsley-numeric": "true",
         *      "data-parsley-numeric-message": "Price format: 99.99",
         *      "data-bv-numeric-separator": ".",
         *
         *      "id": "entity-price",
         *      "class": "form-control",
         *      "autocomplete": "transaction-amount",
         *      "pattern": "^\d+(\.\d+)?$",
         *      "step": 0.01,
         *      "min": 0.00
         * })
         * @ORM\Column(name="amount", type="decimal", precision=20, scale=2, nullable=false, unique=false)
         */
        protected $amount;

        /**
         * Set amount
         * @param int $amount
         * @return $this
         */
        public function setAmount($amount)
        {
            $this->amount = $amount;
            return $this;
        }

        /**
         * Get amount
         * @return int
         */
        public function getAmount()
        {
            return $this->amount;
        }
    }
}
