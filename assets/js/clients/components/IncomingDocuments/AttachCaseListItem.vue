<template>
	<b-list-group-item>
		<b-row>
			<b-col cols="5" md="12" lg="6" class="mb-4 mb-md-0 text-left">
				<b-row>
					<b-col cols="12">
						<case-status-label :value="caseEntity" />
						<br>
						<span class="font-weight-bold"  >
							<span v-if="caseID" title="Case ID" >
								Case ID : {{ caseID }}
							</span>
							<br>
							<span v-if="caseEntity.admit_date && caseEntity.discharge_date"  title="Admit Date - Discharge Date" >
								{{ $filters.formatDate(caseEntity.admit_date) }} 
								&mdash;
							</span>
							<span v-if="caseEntity.discharge_date" title="Admit Date - Discharge Date" >
								{{ $filters.formatDate(caseEntity.discharge_date) }}
								
							</span>
						</span>
					</b-col>
				</b-row>

				<p v-if="caseEntity.admit_date" class="small text-muted mb-0" title="Case Type" >
					<span>
						Case Type 
					</span>
					<span>&mdash;</span>
					<span>
						{{ case_type }}
					</span>
				</p>

				<!-- <p v-if="caseID" class="small text-muted mb-0" title="Case ID">
					<span>{{ caseID }}</span>
				</p> -->
				<p v-if="caseTypeName" class="small text-muted mb-0" title="Case Type">
					<span>{{ caseTypeName }}</span>
				</p>
				<p v-if="clientEmployeeName" class="small text-muted mb-0" title="Physician">
					<font-awesome-icon icon="user-md" fixed-width />
					<span>{{ clientEmployeeName }}</span>
					<span>{{ caseID }}</span>
				</p>
				<p v-if="facilityName" class="small text-muted mb-0" title="Facility">
					<font-awesome-icon icon="building" fixed-width />
					<span>{{ facilityName }}</span>
					

				</p>
			</b-col>
			<b-col cols="7" md="12" lg="6" class="mb-4 mb-md-0 text-right">
				<b-dropdown right menu-class="shadow" variant="primary">
					<template #button-content>
						<font-awesome-icon icon="plus" fixed-width />
						<span>New</span>
					</template>

					<b-dropdown-item
						@click="
							addingAppeal = true;
							addingRequest = false;
						"
						:active="addingAppeal"
					>
						<span>Appeal</span>
					</b-dropdown-item>

					<b-dropdown-item
						@click="
							addingRequest = true;
							addingAppeal = false;
						"
						:active="addingRequest"
					>
						<span>Request</span>
					</b-dropdown-item>
				</b-dropdown>

				<b-dropdown right menu-class="shadow" variant="secondary">
					<template #button-content>
						<font-awesome-icon icon="cog" fixed-width />
					</template>
					<b-dropdown-item :to="{ name: 'cases.view', params: { id: caseEntity.id } }">
						<font-awesome-icon icon="eye" fixed-width />
						<span>View Case</span>
					</b-dropdown-item>

					<b-dropdown-divider />

					<b-dropdown-item :to="{ name: 'cases.edit', params: { id: caseEntity.id } }">
						<font-awesome-icon icon="edit" fixed-width />
						<span>Edit Case</span>
					</b-dropdown-item>
				</b-dropdown>
			</b-col>
		</b-row>
		<b-row v-if="addingAppeal" class="my-2">
			<b-col cols="12">
				<appeal-form
					:case-entity="caseEntity"
					@saved="addedAppeal"
					@cancel="addingAppeal = false"
					class="shadow"
				>
					<template #header>
						<b-card-header>
							<div class="d-flex justify-content-between align-items-center">
								<span class="font-weight-bold">Add New Appeal</span>
								<b-button
									variant="secondary"
									size="sm"
									@click="addingAppeal = false"
									title="Cancel"
									class="mb-0"
								>
									<font-awesome-icon icon="remove" fixed-width class="my-0 py-0" />
								</b-button>
							</div>
						</b-card-header>
					</template>
				</appeal-form>
			</b-col>
		</b-row>
		<b-row v-else-if="addingRequest" class="my-2">
			<b-col cols="12">
				<case-request-form :case-entity="caseEntity" @saved="addedRequest" @cancel="addingRequest = false">
					<template #header>
						<b-card-header>
							<div class="d-flex justify-content-between align-items-center">
								<span class="font-weight-bold">Add New Request</span>
								<b-button
									variant="primary"
									size="sm"
									@click="autoFillForm"
									class="mt-2"
								>
									Auto-fill 
								</b-button>

								<b-button
									variant="secondary"
									size="sm"
									@click="addingRequest = false"
									title="Cancel"
									class="mb-0"
								>
									<font-awesome-icon icon="remove" fixed-width class="my-0 py-0" />
								</b-button>
							</div>
						</b-card-header>
					</template>
				</case-request-form>
			</b-col>
		</b-row>
		<div v-else-if="hasAppeals || hasRequests" class="my-2">
			<!-- <div v-if="hasRequests" >
				<b-card v-if="request_appeal_level[index]=='0'" no-body>
					<b-card-header v-if="hasRequests">Pre-Appeal </b-card-header>
					<b-list-group flush>
						<b-list-group-item v-for="caseRequest in requests" :key="caseRequest.id" class="shadow-sm">
						
							<p class="font-weight-bold mb-0">
								<span >
									{{ caseRequest.name }}
								</span>
								
							</p>
							<p class="mb-0 text-muted">
								<span v-if="caseRequest.type_label"> {{ caseRequest.type_label }} Request </span>
							</p>
							<p v-if="caseRequest.status_label !== 'Closed'" class="mb-0">
								<span
									v-if="caseRequest.due_date"
									class="small"
									:class="caseRequest.is_overdue ? 'text-danger font-weight-bold' : 'text-muted'"
								>
									Due on {{ $filters.formatDate(caseRequest.due_date) }}
								</span>
							</p>
						</b-list-group-item>
					</b-list-group>
				</b-card>
			</div> -->
			<div >
				<div v-if="hasRequests" ></div> 	<!--  do not remove this line -->
				<b-card v-if="hasRequests" no-body>
					<b-card-header>Pre Appeal 123 </b-card-header>
					<b-list-group v-for="index in request_name.length" :key="index" flush >
						
						<b-list-group-item v-if="request_appeal_level[index-1]==0" class="shadow-sm">
							<p  class="font-weight-bold mb-0">
								
								<span>{{request_name[index-1]}}</span>
								
							</p>
							<p  class="mb-0 text-muted">
								 {{request_type[index-1]}}
							</p>
							<p  class="mb-0">
								<span
									class='small text-danger font-weight-bold' 
								>
									Due on {{ request_duedate[index-1] }}
								</span>
							</p>

							<b-col cols="4" md="6" lg="12" xl="6" class="text-right">
									<b-dropdown
										split
										right
										@click="attachToAppeal(appeal, { redirect: false })"
										:disabled="attaching"
										variant="primary"
									>
										<template #button-content>
											<font-awesome-icon icon="paperclip" fixed-width />
											<span>Attach</span>
										</template>
										<b-dropdown-item-button
											@click="attachToAppeal(appeal, { redirect: true })"
											:disabled="attaching"
											title="Attach and view appeal"
										>
											<div>Attach &amp; View</div>
											<small class="text-muted"> Attach document and view appeal after. </small>
										</b-dropdown-item-button>
									</b-dropdown>
								</b-col>
						</b-list-group-item>
					</b-list-group>
				</b-card>
			</div>
			<!-- <div v-if="hasAppeals">
				<b-card no-body>
					<b-card-header>Appeals</b-card-header>
					<b-list-group flush>
						<b-list-group-item v-for="appeal in appeals" :key="appeal.id" class="shadow-sm">
							<b-row>
								<b-col cols="8" md="6" lg="12" xl="6" class="text-left mb-2 mb-md-0">
									<p class="mb-0">
										<span v-if="appeal.appeal_level && appeal.appeal_level.name">
											{{ appeal.appeal_level.name }}
										</span>
										<span v-else class="text-danger"> Missing Level </span>
										<span v-if="appeal.appeal_level && appeal.appeal_type" class="text-muted">
											&mdash;
										</span>
										<span v-if="appeal.appeal_type && appeal.appeal_type.name" class="text-muted">
											{{ appeal.appeal_type.name }}
										</span>
										<span v-else class="text-danger"> Missing Type </span>
										<appeal-status-label :value="appeal" />
									</p>
									<p v-if="appeal.appeal_status !== 'Closed'" class="mb-0">
										<span
											v-if="appeal.due_date"
											class="small"
											:class="appeal.is_overdue ? 'text-danger font-weight-bold' : 'text-muted'"
										>
											Due on {{ $filters.formatDate(appeal.due_date) }}
										</span>
									</p>
									<p v-if="appeal.modified" class="small text-muted mb-0">
										Last updated {{ $filters.formatTimestamp(appeal.modified) }}
									</p>
								</b-col>
								<b-col cols="4" md="6" lg="12" xl="6" class="text-right">
									<b-dropdown
										split
										right
										@click="attachToAppeal(appeal, { redirect: false })"
										:disabled="attaching"
										variant="primary"
									>
										<template #button-content>
											<font-awesome-icon icon="paperclip" fixed-width />
											<span>Attach</span>
										</template>
										<b-dropdown-item-button
											@click="attachToAppeal(appeal, { redirect: true })"
											:disabled="attaching"
											title="Attach and view appeal"
										>
											<div>Attach &amp; View</div>
											<small class="text-muted"> Attach document and view appeal after. </small>
										</b-dropdown-item-button>
									</b-dropdown>
								</b-col>
							</b-row>
						</b-list-group-item>
					</b-list-group>
				</b-card>
			</div> -->

			<!-- for rendering levels and its appeals -->

			<!-- <div v-if="hasAppeals "> -->
			<!-- index in request_name.length -->
				<!-- <b-card v-for="index in appeals.length" :key="index" no-body>
					<b-card-header>{{appeals[index].appeal_level.id}}</b-card-header>
				</b-card>
			</div> -->

			<div v-if="hasAppeals ">
				<b-card v-for="appeal,index in appeals" :key="appeal.id" no-body>
					<b-card-header>{{ appeal.appeal_level.name }} </b-card-header>
					<b-list-group flush>
						<b-list-group-item  class="shadow-sm">
							<b-row>
								<b-col cols="8" md="6" lg="12" xl="6" class="text-left mb-2 mb-md-0">
									<div v-if="hasRequests" >
										<div v-for="level, i in request_appeal_level" :key=i >
											<p  class="font-weight-bold mb-0" >
												
													<span v-if="appeal.appeal_level.id==level">
														{{request_name[i]}} 
													</span>
												

											</p>
											<p class="mb-0 text-muted">	
												
													<span v-if="appeal.appeal_level.id==level">
														{{request_type[i]}}
													</span>
												
											</p>
											<p class="mb-0">
												
													<span v-if="appeal.appeal_level.id==level" class='small text-danger font-weight-bold' >
														Due on {{request_duedate[i]}}
													</span>
												
											</p>
											<br>
										</div>
									</div>
									<p class="mb-0">
										
										<span v-if="appeal.appeal_level && appeal.appeal_level.name">
											{{ appeal.appeal_level.name }}
										</span>
										<span v-else class="text-danger"> Missing Level </span>
										<span v-if="appeal.appeal_level && appeal.appeal_type" class="text-muted">
											&mdash;
										</span>
										<span v-if="appeal.appeal_type && appeal.appeal_type.name" class="text-muted">
											{{ appeal.appeal_type.name }}
										</span>
										<span v-else class="text-danger"> Missing Type </span>
										<appeal-status-label :value="appeal" />
									</p>
									<p v-if="appeal.appeal_status !== 'Closed'" class="mb-0">
										<span
											v-if="appeal.due_date"
											class="small"
											:class="appeal.is_overdue ? 'text-danger font-weight-bold' : 'text-muted'"
										>
											Due on {{ $filters.formatDate(appeal.due_date) }}
										</span>
									</p>
									<p v-if="appeal.modified" class="small text-muted mb-0">
										Last updated {{ $filters.formatTimestamp(appeal.modified) }}
									</p>
								</b-col>
								<b-col cols="4" md="6" lg="12" xl="6" class="text-right">
									<b-dropdown
										split
										right
										@click="attachToAppeal(appeal, { redirect: false })"
										:disabled="attaching"
										variant="primary"
									>
										<template #button-content>
											<font-awesome-icon icon="paperclip" fixed-width />
											<span>Attach</span>
										</template>
										<b-dropdown-item-button
											@click="attachToAppeal(appeal, { redirect: true })"
											:disabled="attaching"
											title="Attach and view appeal"
										>
											<div>Attach &amp; View</div>
											<small class="text-muted"> Attach document and view appeal after. </small>
										</b-dropdown-item-button>
									</b-dropdown>
								</b-col>
							</b-row>
						</b-list-group-item>
					</b-list-group>
				</b-card>
			</div>

		</div>

		


		<div v-else>
			<b-alert show variant="info" class="my-2">
				<font-awesome-icon icon="exclamation-triangle" fixed-width />
				No appeals or requests have been created for this case.
			</b-alert>
		</div>
	</b-list-group-item>
</template>

<script>
import AppealForm from "@/clients/components/Appeals/Form.vue";
import AppealStatusLabel from "@/clients/components/Appeals/StatusLabel.vue";
import CaseStatusLabel from "@/clients/components/Cases/StatusLabel.vue";
import CaseRequestForm from "@/clients/components/CaseRequests/Form.vue";
import axios from "axios";

export default {
	name: "AttachCaseListItem",
	components: {
		AppealForm,
		AppealStatusLabel,
		CaseStatusLabel,
		CaseRequestForm,
	},
	props: {
		patient: {
			required: true,
			type: Object,
			default: () => {
				return {
					id: null,
					first_name: null,
					last_name: null,
					full_name: null,
					list_name: null,
				};
			},
		},
		caseEntity: {
			type: Object,
			default: () => {
				return {
					id: null,
					appeals: [],
					case_requests: [],
					case_type: {
						id: null,
						request_available: false,
					},
					facility: {
						id: null,
						name: null,
					},
				};
			},
		},
		document: {
			required: true,
			type: Object,
			default: () => {
				return {
					id: null,
					created: null,
				};
			},
		},
	},
	data() {
		return {
			addingAppeal: false,
			appeals: this.caseEntity.appeals || [],

			addingRequest: false,
			requests: this.caseEntity.requests || [],

			loading: false,
			attaching: false,
			new_data : [],
			name:"abcd",
			requests_details:[],
			request_name:[],
			request_type:[],
			request_duedate:[],
			request_appeal_level:[],
			case_type:'',
			letterData: null,			
		};
	},
	computed: {
		caseTypeName() {
			return this.caseEntity.case_type?.name ?? "";
		},
		clientEmployeeName() {
			return this.caseEntity.client_employee?.full_name ?? "";
		},
		facilityName() {
			return this.caseEntity.facility?.name ?? "";
		},
		hasAppeals() {
			return this.appeals.length > 0;
		},
		hasRequests() {
			
			for (let i=0;i<this.new_data.length;i++){
				
				if(this.new_data[i].case_id==this.caseEntity.appeals[0].case_id)
				{
					this.request_name.push(this.new_data[i].name);
					this.request_type.push(this.new_data[i].request_type);
					this.request_duedate.push(this.new_data[i].due_date);
					this.request_appeal_level.push(this.new_data[i].status)
					this.request_available=true;
					
				}
			}
					
					console.log('appeals 123 = ', this.appeals);
					return this.request_available;
				
			
		},
		caseID() {
			
			this.case_type =(this.caseEntity.appeals[0].appeal_type.name);

			for (let i=0;i<this.new_data.length;i++){
				if(this.new_data[i].case_id==this.caseEntity.appeals[0].case_id){
					return this.caseEntity.appeals[0].case_id;
				}
			}
		
		},


	},
	methods: {

		// console.log(response.data[i].case_id);


		async fetchDataFromController() 
		{
			try {
				const response = await axios.get("/client/requests"); // Replace with the actual endpoint
				console.log(response.data);
				this.new_data = response.data
				// return response.data[0].case_id;appeals
			} catch (error) {
				console.error(error);
				throw error;
			}
		},



		addedAppeal(appeal) 
		{
			this.addingAppeal = false;
			this.appeals.push(appeal);

			this.$emit("added-appeal", appeal);
		},
		addedRequest(request) {
			this.addingRequest = false;
			this.requests.push(request);

			this.$emit("added-request", request);
		},
		async attachToAppeal(appeal, options = {}) {
			try {
				this.attaching = true;

				const response = await this.$store.dispatch("incomingDocuments/attachAppeal", {
					id: this.document.id,
					case_id: appeal.case_id,
					appeal_id: appeal.id,
				});

				this.$emit("attached", response);

				if (options.redirect && options.redirect === true) {
					this.$router.push({
						name: "appeals.view",
						params: {
							id: appeal.case_id,
							appeal_id: appeal.id,
						},
					});
				}
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Attach Failed",
					message: "An error occurred when attempting to attach to appeal.",
				});
			} finally {
				this.attaching = false;
			}
		},
		async attachToCase(caseEntity, options = {}) {
			let message = `Are you sure you want to merge the current document in with case #${caseEntity.id} (Admit Date: ${caseEntity.admit_date})?`;

			if (!redirectAfter) {
				message +=
					" The document will be removed from the queue and you will need to search the patient in order to find it again.";
			}

			if (!confirm(message)) {
				return false;
			}

			try {
				const response = await this.$store.dispatch("incomingDocuments/attachCase", {
					id: this.document.id,
					case_id: caseEntity.id,
				});

				this.$emit("attached-case", response);

				if (options.redirect && options.redirect === true) {
					this.$router.push({
						name: "cases.view",
						params: {
							id: caseEntity.id,
						},
					});
				}
			} catch (e) {
				this.$store.dispatch("apiError", {
					error: e,
					title: "Attach Failed",
					message: "An error occurred when attempting to attach to case.",
				});
			} finally {
				if (!redirectAfter) {
					this.$emit("refresh");
				}
			}
		},

		async autoFillForm() {
			try {
				const url = "http://localhost:8765/client/textract";
				
				const responses = await axios.get(url, {
				headers: {
					"Accept": "application/json",
					// You can add other headers here if needed
				},
				});
				this.letterData = responses.data[0]; 
				console.log("Response:", this.letterData);

				
				// You can process the response data and update the form fields here
				
			} catch (error) {
				console.error("Error:", error);
			}
    	},
	},

	async mounted() {
    try {
      await this.fetchDataFromController();
      console.log('Data fetched and updated successfully');
    } catch (error) {
      console.error('Error fetching data:', error);
    }

  },
};
</script>
