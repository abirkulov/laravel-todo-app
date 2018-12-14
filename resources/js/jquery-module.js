import {
    getDeleteModal, inputErrorsListener,
    deleteFlashMessage, clearErrorsOnInput
} from './functions';

$(document).ready(() => {

    /**
     * Common events for deleting Flash Messages
     * and errors on form input
     */
    deleteFlashMessage();
    inputErrorsListener();

    /**
     * Events for Posts
     */
    $('.delete-post-btn').on('click', function(){
        let deleteRoute = '/posts/delete/' + $(this).data('id');
        getDeleteModal(deleteRoute);
    });

    /**
     * Events for Categories
     */
    $('.edit-category-btn').on('click', function(){
        let listGroupItems = $(this).closest(".list-group-item")
            .siblings();

        listGroupItems.children('.edit-category-form')
            .removeClass("d-block").addClass("d-none");
        listGroupItems.children('.category-display')
            .removeClass("d-none").addClass("d-block");

        let categoryDisplay = $(this).closest('.category-display');
        let editCategoryForm = $(this).closest('.category-display')
            .siblings('.edit-category-form');

        categoryDisplay.removeClass('d-block').addClass('d-none');
        editCategoryForm.removeClass('d-none').addClass('d-block');
    });

    $(".category-name").on("dblclick", function(){
        let listGroupItems = $(this).closest(".list-group-item")
            .siblings();

        listGroupItems.children('.edit-category-form')
            .removeClass("d-block").addClass("d-none");
        listGroupItems.children('.category-display')
            .removeClass("d-none").addClass("d-block");

        let categoryDisplay = $(this).closest('.category-display');
        let editCategoryForm = $(this).closest('.category-display')
            .siblings('.edit-category-form');

        categoryDisplay.removeClass('d-block').addClass('d-none');
        editCategoryForm.removeClass('d-none').addClass('d-block');
    });

    $('.cancel-edit-category-btn').on('click', function () {
        let editCategoryForm = $(this).closest('.edit-category-form');
        let categoryDisplay = $(this).closest('.edit-category-form')
            .siblings('.category-display');

        editCategoryForm.removeClass('d-block').addClass('d-none');
        categoryDisplay.removeClass('d-none').addClass('d-block');
    });

    $('.delete-category-btn').on('click', function () {
        let deleteRoute = '/categories/delete/' + $(this).data('id');
        getDeleteModal(deleteRoute);
    });

    /**
     * Events for Roles
     */
    $('.delete-role-btn').on('click', function () {
        let deleteRoute = '/roles/delete/' + $(this).data('id');
        getDeleteModal(deleteRoute);
    });

    $("#permissions").chosen();

    /**
     * Events for Users
     */
    $("#roles").chosen();

    $('.delete-user-btn').on('click', function () {
        let deleteRoute = '/users/delete/' + $(this).data('id');
        getDeleteModal(deleteRoute);
    });

});