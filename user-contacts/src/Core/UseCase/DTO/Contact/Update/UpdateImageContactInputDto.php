<?php

namespace Core\UseCase\DTO\Contact\Update;

use Illuminate\Http\UploadedFile;

class UpdateImageContactInputDto
{
    public function __construct(
        public string $id,
        public ?UploadedFile $image,
    ) {
    }
}
