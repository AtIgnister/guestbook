<?php

test('example', function () {
    $response = $this->get('/captcha/default');
    $response->assertStatus(200);
    $this->assertEquals(
        'image/jpeg',
        $response->headers->get('Content-Type')
    );
});