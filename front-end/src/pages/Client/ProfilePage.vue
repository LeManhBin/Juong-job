<template lang="">
    <div class="max-w-[1300px] mx-auto mt-[150px] flex gap-5 max-md:flex-col-reverse max-sm:px-[20px]">
        <div class="w-[60%] max-md:w-full shadow p-[20px] rounded-xl">
            <h3 class="font-semibold text-[20px]">Cài đặt thông tin cá nhân</h3>
            <form action="" class="flex flex-col gap-4 mt-5" @submit.prevent="handleSubmit">
                <div class="flex flex-col gap-1">
                    <label for="" class="text-[14px] font-medium">Họ và tên <RedTick/></label>
                    <input type="text" v-model="profileRef.name" placeholder="Nhập họ và tên" class="px-[10px] py-[5px] outline-none rounded border">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="" class="text-[14px] font-medium">Ngày sinh <RedTick/></label>
                    <input type="date" v-model="profileRef.birthday" class="px-[10px] py-[5px] outline-none rounded border">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="" class="text-[14px] font-medium">Địa chỉ <RedTick/></label>
                    <input type="text" v-model="profileRef.address" placeholder="Nhập địa chỉ" class="px-[10px] py-[5px] outline-none rounded border">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="" class="text-[14px] font-medium">Số điện thoại <RedTick/></label>
                    <input type="text" v-model="profileRef.phone" placeholder="Nhập số điện thoại" class="px-[10px] py-[5px] outline-none rounded border">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="" class="text-[14px] font-medium">Email</label>
                    <input type="email" v-model="profileRef.email" :disabled="true" placeholder="Nhập email" class="px-[10px] py-[5px] outline-none rounded border">
                </div>
                <button type="submit" class="text-white font-semibold px-[10px] py-[5px] rounded bg-green-500">Xác nhận</button>
            </form>
        </div>
        <div class="w-[40%] max-sm:w-full max-md:w-full shadow rounded-xl p-[20px]">
            <div class="flex items-center  gap-5 border-b pb-[10px]">
                <div class="relative rounded-full ">
                    <div class="avatar-container">
                        <img
                           v-if="handleCheckLinkImage(profileRef.avatar)"  :src="avatarFile.preview ? `${avatarFile.preview}` : profileRef.avatar"
                            class="w-full h-full object-cover rounded-full"
                        />
                        <img v-else
                            :src="avatarFile.preview ? `${avatarFile.preview}` : `${IMAGE_URL}${profileRef.avatar}`"
                            class="w-full h-full object-cover rounded-full"
                        />
                    </div>
                    <div class="absolute right-[-5px] bottom-0 w-[30px] h-[30px] rounded-full bg-green-500 text-white flex items-center justify-center">
                        <label for="change-avatar" class="flex items-center cursor-pointer"><CameraOutlined :style="{fontSize: '16px', color: '#fff'}"/></label>
                        <input type="file" id="change-avatar" class="hidden" @change="changeFile">
                    </div>
                </div>
                <div>
                    <p class="text-gray-500">Chào bạn trở lại,</p>
                    <p class="font-medium">{{profileRef.name}}</p>
                </div>
            </div>
        </div>
    </div>
    <LoadingVue v-if="userStore.isLoading" />
</template>
<script setup>
    import {CameraOutlined} from "@ant-design/icons-vue"
    import {IMAGE_URL} from "../../constants/url"
    import { useUserStore } from "../../stores/userStore";
    import { ref, watchEffect } from "vue";
    import LoadingVue from "../../components/Loading.vue";
    import RedTick from "../../components/RedTick.vue";
    import {handleCheckLinkImage} from "../../constants/func"
import { useToast } from "vue-toastification";
    const userStore = useUserStore()
    const toast = useToast()
    const avatarFile = ref({
        file: null,
        preview: null,
    })
    const profileRef = ref({
        name: userStore.myUser?.name,
        phone: userStore.myUser?.phone,
        email: userStore.myUser?.email,
        avatar: userStore.myUser?.avatar,
        birthday: userStore.myUser?.birthday,
        address: userStore.myUser?.address,
    }) 

    watchEffect(() => {
        const profile = userStore.myUser;
        if (profile) {
            profileRef.value.name = profile.name;
            profileRef.value.phone = profile.phone;
            profileRef.value.email = profile.email;
            profileRef.value.avatar = profile.avatar;
            profileRef.value.birthday = profile.birthday;
            profileRef.value.address = profile.address;
        }
    });

    const changeFile = (e) => {
        const file = e.target.files[0];
      if (file) {
        avatarFile.value.preview = URL.createObjectURL(file);
        avatarFile.value.file = file;
      }
    }


    const handleSubmit = () => {
        const formData = new FormData();
        formData.append('avatar', avatarFile.value.file);
        formData.append('name', profileRef.value.name)
        formData.append('email', profileRef.value.email)
        formData.append('phone', profileRef.value.phone)
        formData.append('birthday', profileRef.value.birthday) 
        formData.append('address', profileRef.value.address) 
        if(!profileRef.value.name || !profileRef.value.phone || !profileRef.value.birthday || !profileRef.value.address || !avatarFile.value.file){
            toast.warning("Vui lòng nhập đủ thông tin")
        }else {
            userStore.actEditProfile(formData, userStore.accessToken)    
        }
    }

</script>
<style>
    .avatar-container {
        width: 200px;
        height: 200px;
        background-image: url("../../assets/images/user_1177568.png");
        background-size: cover;
        background-position: center;
    }
</style>