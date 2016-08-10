<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright   Copyright (c) 2010 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */
/**
 * Shoping cart model
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Exceedz_Checkout_Model_Cart extends Mage_Checkout_Model_Cart
{
    /**
     * Update cart items information
     *
     * @param   array $data
     * @return  Mage_Checkout_Model_Cart
     */
    public function updateItems($data)
    {        
		Mage::dispatchEvent('checkout_cart_update_items_before', array('cart'=>$this, 'info'=>$data));		
        foreach ($data as $itemId => $itemInfo) {
            $item = $this->getQuote()->getItemById($itemId);
			if (!$item) {
                continue;
            }
            if (!empty($itemInfo['remove']) || (isset($itemInfo['qty']) && $itemInfo['qty']=='0')) {
                $this->removeItem($itemId);
                continue;
            $qty = isset($itemInfo['qty']) ? (float) $itemInfo['qty'] : false;
            if ($qty > 0) {
                $item->setQty($qty);
            }            
        }
        Mage::dispatchEvent('checkout_cart_update_items_after', array('cart'=>$this, 'info'=>$data));
        return $this;
    }
    /**
     * Get shopping cart summary qty
     *
     * @return decimal
     */
    public function getItemsQty()
    {
		return $this->getQuote()->getItemsSummaryQty()*1;
    }
}