@extends('layouts.master')

@section('content')

    <div class="container" id="app">

        <br><br>

        <div class="col-sm-12 row">
            
            <div class="col-sm-3">
                <label>@{{ userSelect }}</label>
                <select class="form-control" name="user_id" v-if="userIds.length != 0" v-model="userId">
                    <option value="">Select User Id</option>
                    <option v-for="(userIdData, index) in userIds">@{{ userIdData }}</option>
                </select>
            </div>

            <div class="col-sm-3">
                <label>@{{ dateFrom }}</label>
                <input class="form-control" type="date" v-model="fromDate">
            </div>

            <div class="col-sm-3">
                <label>@{{ dateTo }}</label>
                <input class="form-control" type="date" v-model="endDate">
            </div>

            <br>
            <button type="button" class="btn btn-succcess" v-on:click="searchData()">Search</button>

        </div>
        
        <br><br><br><br>
        <h2>@{{ reportHeading }}</h2>  
           
        <table class="table table-striped">

            <thead>
                <tr>
                    <th>User Id</th>
                    <th>Feature</th>
                    <th>Mostly Used Times</th>
                </tr>
            </thead>
            
            <tbody>
                <tr v-if="reportData.length != 0" v-for="(record, index) in reportData">
                    <td>@{{ record.user_id }}</td>
                    <td>@{{ record.event }}</td>
                    <td>@{{ record.total_used }}</td>
                </tr>
                <tr v-if="reportData.length == 0">
                    <td colspan="3" style="text-align: center">No Result Found</td>
                </tr>
            </tbody>

        </table>

    </div>

@stop


@section('script')

    <script src="https://unpkg.com/vue@2.6.11/dist/vue.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    
    <script>
        new Vue({
            el: '#app',
            data: {
                reportHeading: 'Report Data List',
                userSelect: 'User Id List',
                dateFrom: 'Date From',
                dateTo: 'Date To',
                userIds: [],
                fromDate: '',
                endDate: '',
                userId: '',
                reportData: []
                
            },
            created: function () {
                
                let vm = this;
                axios.get("api/userIds")
                    .then(function(response) {
                        
                        if(response.data.status == true)
                            vm.userIds = response.data.data;
                           
                    })
                    .catch(function(err) {
                       console.log(err);
                    })
            },
            methods: {

                searchData: function ()
                {   
                    let vm = this, 
                        token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        
                    if(vm.userId == '')
                    {
                        alert('User id is required');
                        return false;
                    }
                    else if(vm.fromDate == '')
                    {
                        alert('Date from is required');
                        return false;
                    }
                    else if(vm.endDate == '')
                    {
                        alert('Date to is required');
                        return false;
                    }
                    else
                    {   
                        data = {
                            'userId':  vm.userId,
                            'fromDate': vm.fromDate,
                            'endDate': vm.endDate
                        };

                        axios.post('api/SearchData', {
                            data: data,
                            headers: { 
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        }).then(function (response){

                            vm.reportData = [];

                            if(response.data.status == true)
                                vm.reportData = response.data.data;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    }
                }
            }
        });
    </script>

@stop