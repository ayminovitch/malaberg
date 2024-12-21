<?php

namespace App\Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\DomCrawler\Crawler;

class CartContext implements Context
{
    private AbstractBrowser $client;

    public function __construct(AbstractBrowser $client)
    {
        $this->client = $client;
    }

    /**
     * @Given I am on the product page for :productName
     */
    public function iAmOnTheProductPageFor(string $productName)
    {
        $product = $this->getProductByName($productName);
        $this->client->request('GET', '/en_US/products/' . $product->getSlug());
        if (!$this->client->getResponse()->isSuccessful()) {
            throw new \Exception('Could not find the product page.');
        }
    }

    /**
     * @Given I have a product in the cart with quantity :quantity
     */
    public function iHaveAProductInTheCartWithQuantity(int $quantity)
    {
        $product = $this->getProductByName('Sample Product');  // Adjust product name
        $this->client->request('GET', '/en_US/cart/add/' . $product->getId(), ['quantity' => $quantity]);
    }

    /**
     * @When I add the product to the cart with quantity :quantity
     */
    public function iAddTheProductToTheCartWithQuantity(int $quantity)
    {
        $product = $this->getProductByName('Sample Product');  // Adjust product name
        $this->client->submitForm('Add to cart', [
            'quantity' => $quantity,
        ]);
    }

    /**
     * @When I update the cart quantity to :quantity
     */
    public function iUpdateTheCartQuantityTo(int $quantity)
    {
        $crawler = $this->client->request('GET', '/en_US/cart');
        $this->client->submitForm('Update Cart', [
            'quantity' => $quantity,
        ]);
    }

    /**
     * @Then I should see the cart with :quantity as the quantity
     */
    public function iShouldSeeTheCartWithAsTheQuantity(int $quantity)
    {
        $crawler = $this->client->request('GET', '/en_US/cart');
        $this->assertContains($crawler->text(), (string) $quantity);
    }

    /**
     * @Then I should see the message :message
     */
    public function iShouldSeeTheMessage(string $message)
    {
        $crawler = $this->client->request('GET', '/en_US/cart');
        $this->assertContains($crawler->text(), $message);
    }

    /**
     * Helper to find product by name
     */
    private function getProductByName(string $name): ProductInterface
    {
        $repository = $this->client->getContainer()->get('sylius.repository.product');
        return $repository->findOneByName($name);
    }
}
