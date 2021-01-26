<template>
    <div>
        <heading class="mb-6">Currency</heading>
        <card class="bg-10 mb-6">
            <h1 class="text-center text-80 pt-0 pb-6"> Currency Conversion</h1>


            <div class="mb-6 text-center">
                <a href="javascript:void(0)" @click="selectTab('inrTOusd','USD')" :class="{'font-bold' : tab === 'inrTOusd'}"> INR vs USD</a> | 
                <a href="javascript:void(0)" @click="selectTab('inrTOgbp','GBP')" :class="{'font-bold' : tab === 'inrTOgbp'}"> INR vs GBP</a> | 
                <a href="javascript:void(0)" @click="selectTab('inrTOeur','EUR')" :class="{'font-bold' : tab === 'inrTOeur'}"> INR vs EUR</a>
            </div>

            <div v-show="tab === 'inrTOusd'" class="pt-5 text-center">
                <h4 class="text-center text-3xl text-80 font-light">1 {{base}} = {{conversion.rate}} {{to}}</h4>
            </div>

            <div v-show="tab === 'inrTOgbp'" class="pt-5 text-center">
                <h4 class="text-center text-3xl text-80 font-light">1 {{base}} =  {{conversion.rate}} {{to}}</h4>
            </div>

            <div v-show="tab === 'inrTOeur'" class="pt-5 text-center">
                <h4 class="text-center text-3xl text-80 font-light">1 {{base}} =  {{conversion.rate}} {{to}}</h4>
            </div>
        </card>
        <card class="bg-10">

            <p class="text-center pt-3 pb-3">Show Currency rate with respect to INR</p>
            <table class="table w-full table-default">
                <thead>
                    <th>Curreny</th>
                    <th>Rate</th>
                </thead>
                <tbody>
                    <tr v-for="item in currencyList" class="text-center">
                        <td>{{item.name}}</td>
                        <td>{{item.rate}}</td>
                    </tr>
                </tbody>
            </table>
        </card>
    </div>
</template>

<script>
export default {
    
    data: () => {
        return {
            currencyList: [],
            conversion: {},
            tab: 'inrTOusd',
            base: 'INR',
            to:'USD'
        }
    },

    methods: {
        selectTab: function(tab,to) {
            this.tab = tab;
            this.to = to;
            Nova.request().get('/nova-vendor/sample/currency-convert/'+this.base+'/'+this.to).then(response => {
                this.conversion = response.data;
                this.$toasted.show(this.base+' converted to '+this.to,{type:'success','duration':500});
            });
        }
    },
 
    mounted() {
        //
        Nova.request().get('/nova-vendor/sample/currency-list').then(response => {
            this.currencyList = response.data;
        });

        Nova.request().get('/nova-vendor/sample/currency-convert/'+this.base+'/'+this.to).then(response => {
            this.conversion = response.data;
        });
    },
}
</script>

<style>
/* Scoped Styles */
</style>
