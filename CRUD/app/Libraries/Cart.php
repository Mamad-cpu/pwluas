<?php

namespace App\Libraries;

class Cart
{
<<<<<<< HEAD
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
=======
    protected string $sessionKey = 'freshwash_cart';

    public function insert(array $item): bool
    {
        if (empty($item['id']) || empty($item['nama']) || ! isset($item['harga'])) {
            return false;
        }

        $cart = $this->getContents();
        $id   = (int) $item['id'];

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += (int) ($item['qty'] ?? 1);
        } else {
            $cart[$id] = [
                'id'      => $id,
                'nama'    => $item['nama'],
                'harga'   => (float) $item['harga'],
                'satuan'  => $item['satuan'] ?? 'pcs',
                'qty'     => (int) ($item['qty'] ?? 1),
                'subtotal' => 0,
            ];
        }

        $cart[$id]['subtotal'] = $cart[$id]['harga'] * $cart[$id]['qty'];

        session()->set($this->sessionKey, $cart);
        return true;
    }

    public function update(int $id, int $qty): bool
    {
        $cart = $this->getContents();

        if (! isset($cart[$id])) {
            return false;
        }

        if ($qty <= 0) {
            return $this->remove($id);
        }

        $cart[$id]['qty']      = $qty;
        $cart[$id]['subtotal'] = $cart[$id]['harga'] * $qty;

        session()->set($this->sessionKey, $cart);
        return true;
    }

    public function remove(int $id): bool
    {
        $cart = $this->getContents();

        if (! isset($cart[$id])) {
            return false;
        }

        unset($cart[$id]);
        session()->set($this->sessionKey, $cart);
        return true;
    }

    public function total(): float
    {
        $cart = $this->getContents();

        if (empty($cart)) {
            return 0.0;
        }

        return (float) array_sum(array_column($cart, 'subtotal'));
    }

    public function destroy(): void
    {
        session()->remove($this->sessionKey);
    }

    public function getContents(): array
    {
        return session()->get($this->sessionKey) ?? [];
    }

    public function count(): int
    {
        return count($this->getContents());
    }

    public function totalQty(): int
    {
        $cart = $this->getContents();

        if (empty($cart)) {
            return 0;
        }

        return (int) array_sum(array_column($cart, 'qty'));
>>>>>>> 8c16e9af2020c66a67919ef6e4717465301975bf
    }
}
