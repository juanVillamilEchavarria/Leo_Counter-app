<?php

namespace App\Application\Profile\Services;
use App\Domains\Profile\Contracts\Repositories\ProfileRepositoryContract;
use App\Domains\Profile\Strategies\Resolvers\UpdateProfileSectionValidateResolver;
use App\Domains\Profile\Factories\ProfileDTOFactory;
use App\Application\Auth\Services\AuthService;
class ProfileService{
    public function __construct(
        private ProfileRepositoryContract $repository,
        private UpdateProfileSectionValidateResolver $resolver,
        private AuthService $authService,
        private ProfileDTOFactory $profileDTOFactory

    )
    {

    }

    public function update(array $data): bool {
        $dto = $this->profileDTOFactory->make($data);
        $user = $this->authService->getAuthenticatedUser();
        $dto = $this->resolver->resolve($dto, $user);
        return $this->repository->update( $user, $dto);
    }
}