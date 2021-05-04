<?php

namespace Presentation\Controllers;

use Presentation\MVC\Controller;
use Presentation\MVC\ViewResult;

class Books extends Controller
{

    public function __construct(
        private \Application\CategoriesQuery $categoriesQuery,
        private \Application\BooksQuery $booksQuery,
        private \Application\BookSearchQuery $bookSearchQuery,
        private \Application\SignedInUserQuery $signedInUserQuery
    ) {
    }

    public function GET_Index(): ViewResult
    {
        return $this->view("bookList", 
        [
            "user" => $this->signedInUserQuery->execute(),
            "categories" => $this->categoriesQuery->execute(),
            "books" => $this->tryGetParam('cid', $categoryId) ? $this->booksQuery->execute($categoryId) : null,
            "selectedCategoryId" => $this->tryGetParam('cid', $categoryId) ? $categoryId : null,
            "context" => $this->getRequestUri()
        ]);
    }

    public function GET_Search(): ViewResult
    {
        return $this->view("bookSearch", [
            "user" => $this->signedInUserQuery->execute(),
            "books" => $this->tryGetParam("f", $value) ? $this->bookSearchQuery->execute($value) : null,
            "filter" => $this->tryGetParam("f", $value) ? $value : null,
            "context" => $this->getRequestUri()
        ]);
    }
}
