<?php

namespace App\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['POST_CREATE', 'POST_EDIT', 'POST_DELETE'])
            && $subject instanceof \App\Entity\Post;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Check if the user is an admin
        if ($user->hasRole('ROLE_ADMIN')) {
            return true;
        }

        switch ($attribute) {
            case 'POST_CREATE':
                // Logic to determine if the user can create a post
                // For example, check if the user is in a specific group
                return $user->isInGroup('post_creators');
            case 'POST_EDIT':
                // Logic to determine if the user can edit a post
                // For example, check if the user is the author or has a specific role
                return $user->getId() === $subject->getAuthor()->getId() || $user->hasRole('ROLE_EDITOR');
            case 'POST_DELETE':
                // Logic to determine if the user can delete a post
                // For example, check if the user is the author or has a specific role
                return $user->getId() === $subject->getAuthor()->getId() || $user->hasRole('ROLE_DELETER');
        }

        // Default to denying access
        return false;
    }
}
