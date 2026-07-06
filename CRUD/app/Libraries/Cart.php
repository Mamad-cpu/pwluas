<?php

namespace App\Libraries;

class Cart
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        if (!$this->session->has('cart')) {
            $this->session->set('cart', []);
        }
    }

    /**
     * Insert item(s) into cart
     */
    public function insert($item)
    {
        if (empty($item) || !is_array($item)) {
            return false;
        }

        $cart = $this->session->get('cart');

        // Check if inserting single item or multiple items
        if (isset($item['id'])) {
            $this->addItem($item, $cart);
        } else {
            foreach ($item as $i) {
                if (isset($i['id'])) {
                    $this->addItem($i, $cart);
                }
            }
        }

        $this->session->set('cart', $cart);
        return true;
    }

    protected function addItem($item, &$cart)
    {
        $id = $item['id'];
        $qty = isset($item['qty']) ? (float)$item['qty'] : 1.0;
        
        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
            $cart[$id]['subtotal'] = $cart[$id]['price'] * $cart[$id]['qty'];
        } else {
            $cart[$id] = [
                'id'       => $id,
                'qty'      => $qty,
                'price'    => (float)$item['price'],
                'name'     => $item['name'],
                'options'  => isset($item['options']) ? $item['options'] : [],
                'subtotal' => (float)$item['price'] * $qty
            ];
        }
    }

    /**
     * Update item quantity/options in cart
     */
    public function update($item)
    {
        if (empty($item) || !is_array($item)) {
            return false;
        }

        $cart = $this->session->get('cart');

        if (isset($item['id'])) {
            $this->updateItem($item, $cart);
        } else {
            foreach ($item as $i) {
                if (isset($i['id'])) {
                    $this->updateItem($i, $cart);
                }
            }
        }

        $this->session->set('cart', $cart);
        return true;
    }

    protected function updateItem($item, &$cart)
    {
        $id = $item['id'];
        if (isset($cart[$id])) {
            if (isset($item['qty'])) {
                $qty = (float)$item['qty'];
                if ($qty <= 0) {
                    unset($cart[$id]);
                } else {
                    $cart[$id]['qty'] = $qty;
                    $cart[$id]['subtotal'] = $cart[$id]['price'] * $qty;
                }
            }
        }
    }

    /**
     * Get total price of items in cart
     */
    public function total()
    {
        $cart = $this->session->get('cart');
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['subtotal'];
        }
        return $total;
    }

    /**
     * Remove single item from cart
     */
    public function remove($id)
    {
        $cart = $this->session->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            $this->session->set('cart', $cart);
            return true;
        }
        return false;
    }

    /**
     * Destroy / clear all items in cart
     */
    public function destroy()
    {
        $this->session->set('cart', []);
        return true;
    }

    /**
     * Get all items in cart
     */
    public function contents()
    {
        return $this->session->get('cart');
    }
}
