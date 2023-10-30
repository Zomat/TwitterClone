<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Bus\CommandBus;
use App\Bus\QueryBus;
use Modules\User\Commands\CreateUserCommand;
use Modules\User\Queries\FindUserQuery;
use Modules\User\Services\IdService;
use Modules\User\ValueObjects\Email;

class UserController extends Controller
{
    public function __construct(
        protected CommandBus $commandBus,
        protected QueryBus $queryBus,
        protected IdService $idService,
    ) {}

    public function __invoke()
    {
        $id = $this->idService->generate();

        $this->commandBus->dispatch(
            new CreateUserCommand(
                id: $id,
                name: fake()->name,
                email: Email::fromString(fake()->email)
            )
        );

        $user = $this->queryBus->ask(
            new FindUserQuery($id)
        );

        dd($user);
    }
}
