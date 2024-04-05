import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { useForm, Head } from '@inertiajs/inertia-react';

export default function Index({auth}) 
{

    const submit = (e) => {
        e.preventDefault();
        post(route('steamlib.update'), { onSuccess: () => reset() });
   
    };
    return(
        <>
        <AuthenticatedLayout
        auth={auth}
        header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">walletData</h2>}
        >
            <Head title="WalletData"/>
            <div>
                <form onSubmit={submit}>
                    
                </form>
            </div>

        </AuthenticatedLayout>
        </>
    )
}