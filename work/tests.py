from django.test import TestCase
from . import models as wm
from django.utils import timezone
from django.urls import reverse

class WorkAvailabalityTestCase(TestCase):

    def setUp(self):

        wm.Work.objects.create(title="Default")

        wm.Work.objects.create(
                title="Earlier", 
                publish_date=timezone.now() - timezone.timedelta(hours=1),
                status=wm.STATUS_PUBLIC)

        wm.Work.objects.create(
                title="Later", 
                publish_date=timezone.now() + timezone.timedelta(hours=1),
                status=wm.STATUS_PUBLIC)

        wm.Work.objects.create(
                title="Yesterday", 
                publish_date=timezone.now() - timezone.timedelta(days=1),
                status=wm.STATUS_PUBLIC)

        wm.Work.objects.create(
                title="Tomorrow", 
                publish_date=timezone.now() + timezone.timedelta(days=1),
                status=wm.STATUS_PUBLIC)

        wm.Work.objects.create(
                title="Past_withdrawn", 
                publish_date=timezone.now() - timezone.timedelta(days=1),
                status=wm.STATUS_WITHDRAWN)

        wm.Work.objects.create(
                title="Future_withdrawn", 
                publish_date=timezone.now() + timezone.timedelta(days=1),
                status=wm.STATUS_WITHDRAWN)

        wm.Work.objects.create(
                title="Past_draft", 
                publish_date=timezone.now() - timezone.timedelta(days=1),
                status=wm.STATUS_DRAFT)

        wm.Work.objects.create(
                title="Future_draft", 
                publish_date=timezone.now() + timezone.timedelta(days=1),
                status=wm.STATUS_DRAFT)

    def test_default_is_draft(self):
        """
        Tests that a post is a draft by default
        """
        obj = wm.Work.objects.get(title="Default")

        # Test object data

        self.assertIs(obj.status, wm.STATUS_DRAFT)
        self.assertIs(obj.is_available(), False)

        # Test view result

        response = self.client.get(reverse("work_list"))
        self.assertTrue(
               obj not in response.context_data['object_list']
        )

    def test_availabality_past(self):
        """
        Test if a older post from now is available
        """
        obj = wm.Work.objects.get(title="Earlier")
        yesterday = wm.Work.objects.get(title="Yesterday")

        # Test object data

        self.assertIs(obj.is_available(), True)
        self.assertIs(yesterday.is_available(), True)

        # Test view result

        response = self.client.get(reverse("work_list"))
        self.assertTrue(
                obj in response.context_data['object_list']
        )

    def test_availabality_future(self):
        """
        Test if a future post from now is not available
        """
        later = wm.Work.objects.get(title="Later")
        tomorrow = wm.Work.objects.get(title="Tomorrow")

        # Test object data

        self.assertIs(later.is_available(), False)
        self.assertIs(tomorrow.is_available(), False)

        # Test view result

        response = self.client.get(reverse("work_list"))
        self.assertTrue(
                later not in response.context_data['object_list']
        )
        self.assertTrue(
                tomorrow not in response.context_data['object_list']
        )

    def test_availabality_not_published(self):
        """
        Test if a not published post is not available
        """
        past_draft = wm.Work.objects.get(title="Past_draft")
        past_withdrawn = wm.Work.objects.get(title="Past_withdrawn")
        future_draft = wm.Work.objects.get(title="Future_draft")
        future_withdrawn = wm.Work.objects.get(title="Future_withdrawn")

        # Test object data

        self.assertIs(past_draft.is_available(), False)
        self.assertIs(past_withdrawn.is_available(), False)
        self.assertIs(future_draft.is_available(), False)
        self.assertIs(future_withdrawn.is_available(), False)

        # Test view result

        response = self.client.get(reverse("work_list"))
        self.assertTrue(
                past_draft not in response.context_data['object_list']
        )
        self.assertTrue(
                past_withdrawn not in response.context_data['object_list']
        )
        self.assertTrue(
                future_draft not in response.context_data['object_list']
        )
        self.assertTrue(
                future_withdrawn not in response.context_data['object_list']
        )

    def test_detail_view_not_published(self):
        """
        Test that not published post can't be viewed
        """
        candidates = ["Past_draft", "Past_withdrawn", "Future_draft", "Future_withdrawn",
                "Default", "Later", "Tomorrow"]

        for candidate in candidates:
            obj = wm.Work.objects.get(title=candidate)
            response = self.client.get(obj.get_absolute_url())
            self.assertEqual(response.status_code, 404)

    def test_detail_view_published(self):
        """
        Test that published posts can be viewed
        """
        candidates = ["Yesterday", "Earlier"]

        for candidate in candidates:
            obj = wm.Work.objects.get(title=candidate)
            response = self.client.get(obj.get_absolute_url())
            self.assertEqual(response.status_code, 200)

    def test_published_query_content(self):
        """
        Test that the published query contains only published posts
        """

        candidates = ["Earlier", "Yesterday"]
        posts = []

        for title in candidates:
            obj = wm.Work.objects.get(title=title)
            posts.append(obj)

        self.assertEqual(
                posts,
                list(wm.Work.objects.published())
        )
