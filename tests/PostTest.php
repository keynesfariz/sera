<?php

class PostTest extends TestCase
{
    public function testShouldReturnAllPosts()
    {
        $this->get('api/v1/realtime/posts');

        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'total',
            'data' => ['*' => [
                'id',
                'title',
                'body',
                'created_at',
                'updated_at',
            ]]
        ]);
    }

    public function testShouldReturnAPost()
    {
        $id = 'dc21e1ad-30cb-4b72-89ab-63823e104a10';

        $this->get("api/v1/realtime/posts/$id");

        $this->seeStatusCode(200);

        $this->seeJsonStructure([
            'data' => [
                'id',
                'title',
                'body',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    public function testShouldCreateAPost()
    {
        $parameters = [
            'title' => 'Unit Test Title',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
        ];

        $this->post('api/v1/realtime/posts', $parameters);

        $this->seeStatusCode(201);

        $this->seeJsonStructure([
            'data' => [
                'id',
                'title',
                'body',
                'created_at',
                'updated_at',
            ]
        ]);
    }
}
