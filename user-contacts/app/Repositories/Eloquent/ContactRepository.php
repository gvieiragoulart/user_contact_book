<?php

namespace App\Repositories\Eloquent;

use App\Models\Contact as ModelsContact;
use App\Repositories\Presenters\PaginationPresenter;
use Core\Domain\Entity\Contact;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\ContactRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Illuminate\Database\Eloquent\Collection;

class ContactRepository implements ContactRepositoryInterface
{
    private $model;

    public function __construct(ModelsContact $model)
    {
        $this->model = $model;
    }

    public function create(Contact $contact): Contact
    {
        $contact = $this->model->create(
            $contact->toArray()
        );

        return $this->mapModelToEntity($contact);
    }

    public function update(Contact $data): Contact
    {
        if (! $contact = $this->model->find($data->id)) {
            throw new NotFoundException();
        }

        $contact->update(
            $data->toArray()
        );

        $contact->save();

        return $this->mapModelToEntity($contact);
    }

    public function delete(string $id): bool
    {
        if (! $contact = $this->model->find($id)) {
            throw new NotFoundException();
        }

        return $contact->delete();
    }

    public function findById(string $id): Contact
    {
        if (! $contact = $this->model->find($id)) {
            throw new NotFoundException();
        }

        return $this->mapModelToEntity($contact);
    }

    public function paginate(string $userId, string $filter = '', string $order = 'DESC', int $page = 1, int $totalPage = 15): PaginationInterface
    {
        $query = $this->model->orderBy('created_at', $order);
        $query->where('user_id', $userId);
        if ($filter) {
            $query->where(function ($query) use ($filter) {
                $query->orWhere('name', 'like', '%'.$filter.'%');
                $query->orWhere('second_name', 'like', '%'.$filter.'%');
                $query->orWhere('email', 'like', '%'.$filter.'%');
                $query->orWhere('number', 'like', '%'.$filter.'%');
            });
        }

        $pagination =  $query->paginate(
            perPage: $totalPage,
            page: $page
        );

        return new PaginationPresenter($pagination);
    }

    public function findAll(string $filter = '', string $order = 'DESC'): array
    {
        $query = $this->model->orderBy('created_at', $order);
        if ($filter) {
            $query->where(function ($query) use ($filter) {
                $query->orWhere('name', 'like', '%'.$filter.'%');
                $query->orWhere('second_name', 'like', '%'.$filter.'%');
                $query->orWhere('email', 'like', '%'.$filter.'%');
                $query->orWhere('phone', 'like', '%'.$filter.'%');
            });
        }

        return $query->get()->all();
    }

    private function mapModelToEntity(ModelsContact $model): Contact
    {
        return new Contact(
            id: $model->id,
            userId: $model->user_id,
            name: $model->name,
            secondName: $model->second_name,
            email: $model->email,
            number: $model->number,
            imagePath: $model->image_path,
        );
    }
}
