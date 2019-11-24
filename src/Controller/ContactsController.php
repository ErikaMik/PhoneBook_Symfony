<?php

namespace App\Controller;

use App\Entity\ContactRelations;
use App\Entity\Contacts;
use App\Form\ContactsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User;

class ContactsController extends AbstractController
{
    /**
     * @Route("/contacts", name="contacts")
     */
    public function index()
    {
        return $this->render('contacts/index.html.twig', [
            'controller_name' => 'ContactsController',
        ]);


    }

    /**
     * @Route("/create-contact", name="create-contact")
     */
    public function createContact(Request $request)
    {
        $contact = new Contacts();
        $form = $this->createForm(ContactsType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $user = $this->getUser();
            $userId = $user->getId();

            $contact->setUserId($userId);
            $contact = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            return $this->redirect('http://194.5.157.97/symfony/balticamadeus/public/index.php');

        }

        return $this->render(
            'edit.html.twig',
            array('form' => $form->createView())
        );

    }

    /**
     * @Route("/view-contact/{id}", name="view-contact")
     */
    public function viewContacts($id)
    {
        $contact = $this->getDoctrine()
            ->getRepository('App\Entity\Contacts')
            ->find($id);

        if (!$contact) {
            throw $this->createNotFoundException(
                'There are no contacts with the following id: ' . $id
            );
        }

        return $this->render(
            'view.html.twig',
            array('contact' => $contact)
        );
    }

    /**
     * @Route("/show-contacts", name="show-contacts")
     */
    public function showContacts()
    {
        $userId = $this->getUser()->getId();
        $contacts = $this->getDoctrine()
            ->getRepository('App\Entity\Contacts')
            ->findBy(array('user_id' => $userId));

        return $this->render(
            'show.html.twig',
            array('contacts' => $contacts)
        );
    }

    /**
     * @Route("/delete-contact/{id}", name="delete-contact")
     */
    public function deleteContact($id)
    {
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository('App\Entity\Contacts')->find($id);

        if (!$contact) {
            throw $this->createNotFoundException(
                'There are no contacts with the following id: ' . $id
            );
        }

        $em->remove($contact);
        $em->flush();

        return $this->redirect('/show-contact');
    }

    /**
     * @Route("/update-contact/{id}", name="update-contact")
     */
    public function updateContact(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository('App\Entity\Contacts')->find($id);

        if (!$contact) {
            throw $this->createNotFoundException(
                'There are no contacts with the following id: ' . $id
            );
        }

        $form = $this->createForm(ContactsType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $contact = $form->getData();
            $em->flush();
            return $this->redirect('/view-contact/' . $id);
        }

        return $this->render(
            'edit.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/share-contact/{id}", name="share-contact")
     */
    public function shareContact($id)
    {
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository('App\Entity\Contacts')->find($id);
        $users = $em->getRepository('App\Entity\User')->findAll();

        return $this->render(
            'share.html.twig',
            array('contact' => $contact, 'users' => $users));
    }

    /**
     * @Route("/create-share/{id}", name="create-share")
     */
    public function createShare(Request $request, $id)
    {
        $relation = new ContactRelations();
        $relation->setContactId($id);

        $user = $this->getUser();
        $userId = $user->getId();
        $relation->setOwnerId($userId);

        $owner_id = $request->get('owner');
        $relation->setUserId($owner_id);

        $em = $this->getDoctrine()->getManager();
        $em->persist($relation);
        $em->flush();

        return $this->redirect('http://194.5.157.97/symfony/balticamadeus/public/index.php/shared-contacts');
    }


    /**
     * @Route("/shared-contacts", name="shared-contacts")
     */
    public function sharedContacts()
    {
        $userId = $this->getUser()->getId();
        $contacts = $this->getDoctrine()
            ->getRepository('App\Entity\ContactRelations')
            ->findBy(array('owner_id' => $userId));

        $contactIds = array();
        foreach ($contacts as $contact)
        {
            $contactId = $contact->getContactId();
            $contactIds[] = $contactId;
        }

        $sharedContacts = $this->getDoctrine()
            ->getRepository('App\Entity\Contacts')
            ->findBy(array('id' => $contactIds));

        return $this->render(
            'shared-contacts.html.twig',
            array('contacts' => $sharedContacts));
    }

    /**
     * @Route("/terminate-share/{id}", name="terminate-share")
     */
    public function terminateShare($id)
    {
        $em = $this->getDoctrine()->getManager();
        $sharedContact = $em->getRepository('App\Entity\ContactRelations')
            ->findOneBy(array('contact_id' => $id));
        $em->remove($sharedContact);
        $em->flush();
        return $this->redirect('http://194.5.157.97/symfony/balticamadeus/public/index.php/shared-contacts');
    }
}
