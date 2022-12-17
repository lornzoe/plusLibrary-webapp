import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PrimaryButton from '@/Components/PrimaryButton';

import { useForm, Head } from '@inertiajs/inertia-react';
import SteamGame from '@/Components/SteamGame';
 
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
            <div className="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
                <div className="flex mt-4">
                    <a href="/refreshsteamlib">
                        <PrimaryButton processing={processing}>/refreshsteamlib</PrimaryButton>
                    </a>
                    <small className="ml-3 text-sm text-gray-400"> last job execution: {new Date(lastupdate.updated_at).toLocaleString()}</small>
                </div>

                <div className="mt-6 bg-white shadow-sm rounded-lg divide-y">
                    {recentgames.map(
                        steamgame=>
                        <SteamGame key={steamgame.id} steamgame={steamgame}/>
                    )}
                </div>

            </div>


        </AuthenticatedLayout>
    );
}
