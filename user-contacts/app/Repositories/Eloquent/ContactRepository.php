<?php

namespace App\Repositories\Eloquent;

use App\Models\Contact as ModelsContact;
use App\Repositories\Presenters\PaginationPresenter;
use Core\Domain\Entity\Contact;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\ContactRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;

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
        $contact = $this->findById($data->id);
        $contact->update(
            name: $data->name,
            secondName: $data->secondName,
            email: $data->email,
            number: $data->number
        );

        return $contact;
    }

    public function delete(string $id): bool
    {
        if (! $category = $this->model->find($id)) {
            throw new NotFoundException('Category Not Found');
        }

        return $category->delete();
    }

    public function findById(string $id): Contact
    {
        if (! $category = $this->model->find($id)) {
            throw new NotFoundException('Category Not Found');
        }

        return $this->mapModelToEntity($category);
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

        $paginator = $query->paginate($totalPage, ['*'], 'page', $page);

        return new PaginationPresenter($paginator);
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
        );
    }
}
