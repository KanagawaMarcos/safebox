from django.contrib.auth.models import User
from varys.models import Box

def who_did():
    #Get all users from database
    all_users = User.objects.all()
    #Empty tuple of tuples
    users_options = ()
    #loop throught all users and get their names
    for cur_user in all_users:
        if not cur_user.groups.filter(name='Administradores').exists():
            users_options += ((cur_user.get_full_name(), cur_user.get_full_name()),)
    return users_options

def which_box():
    #Get all boxes from database
    all_boxes = Box.objects.all()
    #Empty tuple of tuples
    boxes_options = ()
    #loop throught all boxes and get their names
    for cur_box in reversed(all_boxes):
        boxes_options += ((cur_box.name , cur_box.name ),)
    return boxes_options
