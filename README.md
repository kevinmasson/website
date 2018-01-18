- Python **3.6.1**
- Django **1.11**

# Setup

	cp website/settings.py.default website/settings.py
	# edit settings file
	./manage.py migrate
	./manage.py createsuperuser
	./manage.py collectstatic
	./manage.py runserver

# SASS Setup

	bourbon install --path=sass
	cd sass && neat install && cd -
	cd sass && bitters install && cd -
	./manage.py collectstatic
