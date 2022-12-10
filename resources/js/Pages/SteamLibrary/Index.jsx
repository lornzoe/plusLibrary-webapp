import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

import { useForm, Head } from '@inertiajs/inertia-react';
 
export default function Index({ auth }) {
 
    return (
        <AuthenticatedLayout
        auth={auth}
        header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Library</h2>}
        >
            <Head title="SteamLibrary" />
            


        </AuthenticatedLayout>
    );
}
