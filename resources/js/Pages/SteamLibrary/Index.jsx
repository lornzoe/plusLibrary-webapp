import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PrimaryButton from '@/Components/PrimaryButton';

import { useForm, Head } from '@inertiajs/inertia-react';
import SteamGame_overview from '@/Components/SteamGame_overview';
 
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
 
dayjs.extend(relativeTime);

export default function Index({ auth, recentgames, lastupdate }) {
    const { data, setData, post, processing, reset, errors } = useForm({
        message: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('steamlib.update'), { onSuccess: () => reset() });
    };

    return (
        <AuthenticatedLayout
        auth={auth}
        header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Library</h2>}
        >
            <Head title="SteamLibrary" />
            <div className="max-w-screen-2xl min-w-screen-2xl mx-auto pl-0 pr-0 p-2 lg:p-2 xl:p-8">
                <div className="flex mt-4 pl-2 lg:p-0">
                    <a href="/refreshsteamlib">
                        <PrimaryButton processing={processing}>/refreshsteamlib</PrimaryButton>
                    </a>
                    <small className="ml-3 text-sm text-gray-400"> last job execution: {new Date(lastupdate ? lastupdate.updated_at : null).toLocaleString()}</small>
                    <small className="ml-3 text-sm text-gray-400">// {dayjs(lastupdate ? lastupdate.updated_at : null).fromNow()}</small>
                </div>

                <div className="mt-6 bg-white shadow-sm lg:rounded-lg divide-y">
                    {recentgames.map(
                        steamgame=>
                        <SteamGame_overview key={steamgame.id} steamgame={steamgame}/>
                    )}
                </div>

            </div>


        </AuthenticatedLayout>
    );
}
