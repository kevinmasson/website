from django.shortcuts import render
from django.template import RequestContext

def error_message_view(request, code, title="", message=""):
    response = render(request,
            'website/error.html',
            {
                'request': request,
                'status_code': code,
                'title': title,
                'message': message
            },
            status=code)

    return response

def not_found(request, title="Page not found, 404", message=""):
    if message == "":
        message = "Sorry, this page doesn't exists :("
    return error_message_view(request, 404, title, message)

def bad_request(request, title="Bad request, 400", message=""):
    if message == "":
        message = "Deal with it ;)"
    return error_message_view(request, 400, title, message)

def denied(request, title="Access denied ! 403", message=""):
    if message == "":
        message = "You shall not pass."
    return error_message_view(request, 403, title, message)


def error(request, title="Internal error, 500", message=""):
    if message == "":
        message = "An internal problem, will be fixed as soon as possible !"
    return error_message_view(request, 500, title, message)


